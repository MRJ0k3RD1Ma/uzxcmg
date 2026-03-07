<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;

/**
 * Navigation model
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $icon
 * @property int $image_id
 * @property string $template
 * @property int $parent_id
 * @property int $sort_order
 * @property int $status
 * @property string $created
 * @property string $updated
 * @property int $language_id
 * @property int $category_id
 * @property string $extra_url
 *
 * @property File $image
 * @property Navigation $parent
 * @property Navigation[] $children
 * @property Language $language
 * @property Category $category
 */
class Navigation extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const TEMPLATE_SINGLE = 'SINGLE';
    const TEMPLATE_LIST = 'LIST';
    const TEMPLATE_CATEGORY = 'CATEGORY';
    const TEMPLATE_EXTRA = 'EXTRA';

    public static function tableName()
    {
        return '{{%navigation}}';
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
            [['name'], 'required'],
            [['name', 'slug', 'icon', 'template'], 'string', 'max' => 255],
            [['extra_url'], 'string', 'max' => 500],
            [['parent_id', 'sort_order', 'status', 'image_id', 'language_id', 'category_id'], 'integer'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['sort_order', 'default', 'value' => 0],
            ['template', 'default', 'value' => self::TEMPLATE_SINGLE],
            ['template', 'in', 'range' => [self::TEMPLATE_SINGLE, self::TEMPLATE_LIST, self::TEMPLATE_CATEGORY, self::TEMPLATE_EXTRA]],
            ['extra_url', 'validateExtraUrl'],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['image_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['image_id' => 'id']],
            ['parent_id', 'exist', 'skipOnError' => true, 'targetClass' => self::class, 'targetAttribute' => ['parent_id' => 'id']],
            ['language_id', 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_id' => 'id']],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            ['category_id', 'validateCategoryLanguage'],
        ];
    }

    public function validateCategoryLanguage($attribute, $params)
    {
        if ($this->template === self::TEMPLATE_CATEGORY && !empty($this->category_id)) {
            $category = Category::findOne($this->category_id);
            if ($category && $category->language_id !== $this->language_id) {
                $this->addError($attribute, 'Kategoriya tili navigation tili bilan bir xil bo\'lishi kerak.');
            }
        }
    }

    public function validateExtraUrl($attribute, $params)
    {
        if ($this->template === self::TEMPLATE_EXTRA && empty($this->extra_url)) {
            $this->addError($attribute, 'Extra URL kiritilishi shart.');
        }
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Nomi',
            'slug' => 'Slug',
            'icon' => 'Icon',
            'image_id' => 'Rasm',
            'template' => 'Shablon',
            'parent_id' => 'Ota element',
            'sort_order' => 'Tartib',
            'status' => 'Status',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
            'language_id' => 'Til',
            'category_id' => 'Kategoriya',
            'extra_url' => 'Extra URL',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['created'], $fields['updated'], $fields['image_id'], $fields['language_id'], $fields['category_id']);
        $fields['created_at'] = 'created';
        $fields['updated_at'] = 'updated';

        $fields['status'] = function () {
            return $this->status == self::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE';
        };

        $fields['image'] = function () {
            return $this->getImageData();
        };

        $fields['language_code'] = function () {
            return $this->language ? $this->language->code : null;
        };

        $fields['language_name'] = function () {
            return $this->language ? $this->language->name : null;
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
            'status' => $image->status == File::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE',
            'slug' => $image->slug,
            'exts' => $image->exts,
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
                'sm' => $image->getSmallUrl(),
                'md' => $image->getMediumUrl(),
                'lg' => $image->getOriginalUrl(),
            ];
        }

        return $data;
    }

    public function extraFields()
    {
        return ['parent', 'children', 'language'];
    }

    public function getParent()
    {
        return $this->hasOne(Navigation::class, ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        return $this->hasMany(Navigation::class, ['parent_id' => 'id']);
    }

    public function getImage()
    {
        return $this->hasOne(File::class, ['id' => 'image_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }
}
