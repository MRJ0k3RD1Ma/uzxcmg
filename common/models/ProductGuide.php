<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;

/**
 * ProductGuide model
 *
 * @property int $id
 * @property int $product_id
 * @property int $has_video
 * @property string $title
 * @property string $content
 * @property int $video_id
 * @property int $sort_order
 * @property int $status
 * @property string $created
 * @property string $updated
 * @property string $slug
 *
 * @property Product $product
 * @property File $video
 */
class ProductGuide extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const HAS_VIDEO_NO = 0;
    const HAS_VIDEO_YES = 1;

    public static function tableName()
    {
        return '{{%product_guides}}';
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
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true,
                'immutable' => false,
            ],
        ];
    }

    public function rules()
    {
        return [
            [['product_id', 'title'], 'required'],
            [['title', 'slug'], 'string', 'max' => 255],
            [['content'], 'string'],
            [['product_id', 'has_video', 'video_id', 'sort_order', 'status'], 'integer'],
            ['has_video', 'default', 'value' => self::HAS_VIDEO_YES],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['sort_order', 'default', 'value' => 0],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['has_video', 'in', 'range' => [self::HAS_VIDEO_NO, self::HAS_VIDEO_YES]],
            ['product_id', 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            ['video_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['video_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Mahsulot',
            'has_video' => 'Video mavjud',
            'title' => 'Sarlavha',
            'content' => 'Matn',
            'video_id' => 'Video',
            'sort_order' => 'Tartib',
            'status' => 'Status',
            'slug' => 'Slug',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created'], $fields['updated'], $fields['video_id']);
        $fields['created_at'] = 'created';
        $fields['updated_at'] = 'updated';

        $fields['status'] = function () {
            return $this->status == self::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE';
        };

        $fields['has_video'] = function () {
            return (bool)$this->has_video;
        };

        $fields['video'] = function () {
            return $this->getVideoData();
        };

        return $fields;
    }

    protected function getVideoData()
    {
        $video = $this->video;
        if (!$video) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $video->slug;

        return [
            'id' => $video->id,
            'status' => $video->status == File::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE',
            'slug' => $video->slug,
            'exts' => $video->exts,
            'download_url' => $baseUrl,
        ];
    }

    public function extraFields()
    {
        return ['product'];
    }

    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    public function getVideo()
    {
        return $this->hasOne(File::class, ['id' => 'video_id']);
    }
}
