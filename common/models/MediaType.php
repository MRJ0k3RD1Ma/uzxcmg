<?php

namespace common\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * MediaType model
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property string $created
 * @property string $updated
 */
class MediaType extends ActiveRecord
{
    public const STATUS_INACTIVE = 0;
    public const STATUS_ACTIVE = 1;

    public static function tableName()
    {
        return '{{%media_type}}';
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
            [['name', 'slug'], 'string', 'max' => 255],
            [['status'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'      => 'ID',
            'name'    => 'Nomi',
            'slug'    => 'Slug',
            'status'  => 'Status',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created'], $fields['updated']);
        $fields['created_at'] = 'created';
        $fields['updated_at'] = 'updated';

        $fields['status'] = fn() => $this->status == self::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE';

        return $fields;
    }
}
