<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Language model
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $status
 * @property string $created
 * @property string $updated
 * @property int $icon_id
 *
 * @property File $icon
 */
class Language extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%language}}';
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
        ];
    }

    public function rules()
    {
        return [
            [['name', 'code'], 'required'],
            [['name'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 10],
            [['status', 'icon_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            [['code'], 'unique'],
            ['icon_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['icon_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nomi',
            'code' => 'Kod',
            'icon_id' => 'Ikonka',
            'status' => 'Status',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created'], $fields['updated'], $fields['icon_id']);
        $fields['created_at'] = 'created';
        $fields['updated_at'] = 'updated';

        $fields['status'] = function () {
            return $this->status == self::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE';
        };

        $fields['icon'] = function () {
            return $this->getIconData();
        };

        return $fields;
    }

    protected function getIconData()
    {
        $icon = $this->icon;
        if (!$icon) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $icon->slug;
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $isImage = in_array(strtolower($icon->exts), $imageExtensions);

        $data = [
            'id' => $icon->id,
            'status' => $icon->status == File::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE',
            'slug' => $icon->slug,
            'exts' => $icon->exts,
            'download_url' => $baseUrl,
            'download' => null,
            'url' => null,
        ];

        if ($isImage) {
            $data['download'] = [
                'sm' => $baseUrl . '?size=sm',
                'md' => $baseUrl . '?size=md',
                'lg' => $baseUrl . '?size=lg',
            ];
            $data['url'] = [
                'sm' => $icon->getSmallUrl(),
                'md' => $icon->getMediumUrl(),
                'lg' => $icon->getOriginalUrl(),
            ];
        }

        return $data;
    }

    public function getIcon()
    {
        return $this->hasOne(File::class, ['id' => 'icon_id']);
    }
}
