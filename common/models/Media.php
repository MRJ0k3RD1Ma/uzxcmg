<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * Media model
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $file_id
 * @property int $status
 * @property string $url
 * @property int $has_url
 * @property int $type_id
 * @property string $created
 * @property string $updated
 *
 * @property File $file
 * @property MediaType $mediaType
 */
class Media extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const HAS_URL_NO  = 0;
    const HAS_URL_YES = 1;

    public static function tableName()
    {
        return '{{%media}}';
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
                'class' => 'yii\behaviors\SluggableBehavior',
                'attribute' => 'name',
                'slugAttribute' => 'slug',
                'immutable' => false,
                'ensureUnique' => true,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['file_id', 'status', 'has_url', 'type_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['url'], 'string', 'max' => 2048],
            [['url'], 'url', 'skipOnEmpty' => true],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['has_url', 'default', 'value' => self::HAS_URL_NO],
            ['has_url', 'in', 'range' => [self::HAS_URL_NO, self::HAS_URL_YES]],
            ['file_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['file_id' => 'id']],
            ['type_id', 'exist', 'skipOnError' => true, 'targetClass' => MediaType::class, 'targetAttribute' => ['type_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'name'    => 'Nomi',
            'file_id' => 'Fayl',
            'status'  => 'Status',
            'url'     => 'URL',
            'has_url' => 'URL bormi',
            'type_id' => 'Turi',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created'], $fields['updated'], $fields['file_id'], $fields['type_id']);
        $fields['created_at'] = 'created';
        $fields['updated_at'] = 'updated';

        $fields['status'] = function () {
            return $this->status == self::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE';
        };

        $fields['has_url'] = function () {
            return (bool)$this->has_url;
        };

        $fields['file'] = function () {
            return $this->getFileData();
        };

        $fields['type'] = function () {
            return $this->mediaType;
        };

        return $fields;
    }

    protected function getFileData()
    {
        $file = $this->file;
        if (!$file) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $file->slug;
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $isImage = in_array(strtolower($file->exts), $imageExtensions);

        $data = [
            'id'           => $file->id,
            'name'         => $file->name,
            'slug'         => $file->slug,
            'exts'         => $file->exts,
            'download_url' => $baseUrl,
        ];

        if ($isImage) {
            $data['download'] = [
                'sm' => $baseUrl . '?size=sm',
                'md' => $baseUrl . '?size=md',
                'lg' => $baseUrl . '?size=lg',
            ];
            $data['url'] = [
                'sm' => $file->getSmallUrl(),
                'md' => $file->getMediumUrl(),
                'lg' => $file->getOriginalUrl(),
            ];
        }

        return $data;
    }

    public function getFile()
    {
        return $this->hasOne(File::class, ['id' => 'file_id']);
    }

    public function getMediaType()
    {
        return $this->hasOne(MediaType::class, ['id' => 'type_id']);
    }
}
