<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;

/**
 * Article model
 *
 * @property int $id
 * @property string $slug
 * @property string $name
 * @property int $navigation_id
 * @property string $description
 * @property string $detail
 * @property int $show_counter
 * @property string $publish_date
 * @property int $status
 * @property string $created
 * @property string $updated
 * @property int $language_id
 *
 * @property Navigation $navigation
 * @property Language $language
 */
class Article extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%article}}';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created',
                'updatedAtAttribute' => 'updated',
                'value' => new Expression('NOW()'),
            ],
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable' => false,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name', 'navigation_id', 'description'], 'required'],
            [['name', 'slug'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['detail'], 'string'],
            [['navigation_id', 'show_counter', 'status', 'language_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['show_counter', 'default', 'value' => 0],
            ['publish_date', 'safe'],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['navigation_id', 'exist', 'skipOnError' => true, 'targetClass' => Navigation::class, 'targetAttribute' => ['navigation_id' => 'id']],
            ['language_id', 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Nomi',
            'navigation_id' => 'Navigatsiya',
            'description' => 'Tavsif',
            'detail' => 'Batafsil',
            'show_counter' => 'Ko\'rishlar soni',
            'publish_date' => 'Nashr sanasi',
            'status' => 'Status',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
            'language_id' => 'Til',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created'], $fields['updated'], $fields['language_id'], $fields['navigation_id']);
        $fields['created_at'] = 'created';
        $fields['updated_at'] = 'updated';

        $fields['status'] = function () {
            return $this->status == self::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE';
        };

        $fields['language_code'] = function () {
            return $this->language ? $this->language->code : null;
        };

        $fields['language_name'] = function () {
            return $this->language ? $this->language->name : null;
        };

        $fields['navigation'] = function () {
            return $this->getNavigationData();
        };

        return $fields;
    }

    protected function getNavigationData()
    {
        $navigation = $this->navigation;
        if (!$navigation) {
            return null;
        }

        return [
            'id' => $navigation->id,
            'name' => $navigation->name,
            'slug' => $navigation->slug,
        ];
    }

    public function extraFields()
    {
        return ['language'];
    }

    public function getNavigation()
    {
        return $this->hasOne(Navigation::class, ['id' => 'navigation_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    public function incrementCounter()
    {
        $this->updateCounters(['show_counter' => 1]);
    }
}
