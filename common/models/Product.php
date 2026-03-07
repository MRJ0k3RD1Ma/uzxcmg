<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\SluggableBehavior;
use yii\db\Expression;

/**
 * Product model
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property string $sku
 * @property int $price
 * @property int $discount_price
 * @property string $discount_expires
 * @property string $specifications
 * @property int $stock_quantity
 * @property int $status
 * @property int $featured
 * @property string $seo_title
 * @property string $seo_description
 * @property string $created
 * @property string $updated
 * @property int|null $image_id
 * @property int $rating
 * @property int|null $language_id
 *
 * @property Category $category
 * @property File $image
 * @property Language $language
 * @property ProductImage[] $images
 * @property ProductGuide[] $guides
 * @property ProductSoft[] $softs
 * @property Rating[] $ratings
 */
class Product extends ActiveRecord
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const FEATURED_NO = 0;
    const FEATURED_YES = 1;

    public static function tableName()
    {
        return '{{%product}}';
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
            [['category_id', 'name', 'price'], 'required'],
            [['name', 'slug', 'sku', 'seo_title'], 'string', 'max' => 255],
            [['description', 'seo_description'], 'string'],
            [['category_id', 'price', 'discount_price', 'stock_quantity', 'status', 'featured', 'image_id', 'rating', 'language_id'], 'integer'],
            ['sku', 'unique', 'skipOnEmpty' => true],
            ['slug', 'unique'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['featured', 'default', 'value' => self::FEATURED_YES],
            ['discount_price', 'default', 'value' => 0],
            ['stock_quantity', 'default', 'value' => 0],
            ['rating', 'default', 'value' => 5],
            ['status', 'in', 'range' => [self::STATUS_INACTIVE, self::STATUS_ACTIVE]],
            ['featured', 'in', 'range' => [self::FEATURED_NO, self::FEATURED_YES]],
            ['discount_expires', 'safe'],
            ['specifications', 'safe'],
            ['category_id', 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            ['image_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['image_id' => 'id']],
            ['language_id', 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Kategoriya',
            'name' => 'Nomi',
            'slug' => 'Slug',
            'description' => 'Tavsif',
            'sku' => 'SKU',
            'price' => 'Narx',
            'rating' => 'Reyting',
            'discount_price' => 'Chegirma narxi',
            'discount_expires' => 'Chegirma muddati',
            'specifications' => 'Xususiyatlar',
            'stock_quantity' => 'Ombordagi soni',
            'status' => 'Status',
            'featured' => 'Tanlangan',
            'seo_title' => 'SEO sarlavha',
            'seo_description' => 'SEO tavsif',
            'image_id' => 'Rasm',
            'language_id' => 'Til',
            'created' => 'Yaratilgan',
            'updated' => 'Yangilangan',
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

        $fields['featured'] = function () {
            return (bool)$this->featured;
        };

        $fields['specifications'] = function () {
            return $this->specifications ? json_decode($this->specifications, true) : null;
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

        $fields['category'] = function () {
            return $this->getCategoryData();
        };

        return $fields;
    }

    protected function getCategoryData()
    {
        $category = $this->category;
        if (!$category) {
            return null;
        }

        return [
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
        ];
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
        return ['category', 'language', 'images', 'guides', 'softs', 'ratings'];
    }

    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    public function getImage()
    {
        return $this->hasOne(File::class, ['id' => 'image_id']);
    }

    public function getImages()
    {
        return $this->hasMany(ProductImage::class, ['product_id' => 'id'])
            ->andWhere(['status' => ProductImage::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    public function getGuides()
    {
        return $this->hasMany(ProductGuide::class, ['product_id' => 'id'])
            ->andWhere(['status' => ProductGuide::STATUS_ACTIVE])
            ->orderBy(['sort_order' => SORT_ASC]);
    }

    public function getSofts()
    {
        return $this->hasMany(ProductSoft::class, ['product_id' => 'id'])
            ->andWhere(['status' => ProductSoft::STATUS_ACTIVE]);
    }

    public function getRatings()
    {
        return $this->hasMany(Rating::class, ['product_id' => 'id'])
            ->andWhere(['status' => Rating::STATUS_ACTIVE]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert && empty($this->sku)) {
                $this->sku = $this->generateUniqueSku();
            }
            if (is_array($this->specifications)) {
                $this->specifications = json_encode($this->specifications, JSON_UNESCAPED_UNICODE);
            }
            // ISO formatni MySQL datetime formatga o'tkazish
            if (!empty($this->discount_expires)) {
                try {
                    $date = new \DateTime($this->discount_expires);
                    $this->discount_expires = $date->format('Y-m-d H:i:s');
                } catch (\Exception $e) {
                    // Format noto'g'ri bo'lsa, null qilib qo'yamiz
                    $this->discount_expires = null;
                }
            }
            return true;
        }
        return false;
    }

    protected function generateUniqueSku()
    {
        // Til kodi (UZ, RU, ...)
        $langCode = 'XX';
        if ($this->language_id) {
            $language = Language::findOne($this->language_id);
            if ($language) {
                $langCode = strtoupper($language->code);
            }
        }

        // Nomdan 5 ta harf (faqat harflar, raqamlar)
        $nameClean = preg_replace('/[^A-Za-z0-9]/', '', $this->name);
        $namePart = strtoupper(substr($nameClean, 0, 5));
        // Agar 5 tadan kam bo'lsa, X bilan to'ldirish
        $namePart = str_pad($namePart, 5, 'X');

        // Random qism (7 ta belgi)
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $randomPart = '';
        for ($i = 0; $i < 7; $i++) {
            $randomPart .= $chars[random_int(0, strlen($chars) - 1)];
        }

        do {
            $sku = $langCode . '-' . $namePart . '-' . $randomPart;
            // Agar mavjud bo'lsa, yangi random generatsiya
            if (self::find()->where(['sku' => $sku])->exists()) {
                $randomPart = '';
                for ($i = 0; $i < 7; $i++) {
                    $randomPart .= $chars[random_int(0, strlen($chars) - 1)];
                }
            }
        } while (self::find()->where(['sku' => $sku])->exists());

        return $sku;
    }
}
