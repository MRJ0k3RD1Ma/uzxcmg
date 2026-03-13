<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Banner model
 *
 * @property int $id
 * @property int $language_id
 * @property int $image_id
 * @property string $name
 * @property string $description
 * @property string $button
 * @property int $status
 * @property string $created
 * @property string $updated
 *
 * @property Language $language
 * @property File $image
 */
class Banner extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%banner}}';
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
            [['language_id'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['language_id', 'image_id', 'status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['button', 'safe'],
            ['language_id', 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_id' => 'id']],
            ['image_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['image_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nomi',
            'description' => 'Tavsif',
            'button' => 'Tugma',
            'language_id' => 'Til',
            'image_id' => 'Rasm',
            'status' => 'Status',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created'], $fields['updated'], $fields['language_id'], $fields['image_id']);
        $fields['created_at'] = 'created';
        $fields['updated_at'] = 'updated';

        $fields['status'] = function () {
            return $this->status == self::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE';
        };

        $fields['button'] = function () {
            return $this->button ? json_decode($this->button, true) : null;
        };

        $fields['language_code'] = function () {
            return $this->language ? $this->language->code : null;
        };

        $fields['language_name'] = function () {
            return $this->language ? $this->language->name : null;
        };

        $fields['image'] = function () {
            return $this->getImageData();
        };

        return $fields;
    }

    protected function getImageData()
    {
        $image = $this->image;
        if (!$image) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $image->slug;
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $isImage = in_array(strtolower($image->exts), $imageExtensions);

        $data = [
            'id' => $image->id,
            'name' => $image->name,
            'slug' => $image->slug,
            'exts' => $image->exts,
            'download_url' => $baseUrl,
        ];

        if ($isImage) {
            $data['download'] = [
                'sm' => $baseUrl . '?size=sm',
                'md' => $baseUrl . '?size=md',
                'lg' => $baseUrl . '?size=lg',
            ];
            $data['url'] = [
                'sm' => $image->getSmallUrl(),
                'md' => $image->getMediumUrl(),
                'lg' => $image->getOriginalUrl(),
            ];
        }

        return $data;
    }

    public function extraFields()
    {
        return ['language'];
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    public function getImage()
    {
        return $this->hasOne(File::class, ['id' => 'image_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->button)) {
                $this->button = json_encode($this->button, JSON_UNESCAPED_UNICODE);
            }
            return true;
        }
        return false;
    }
}
