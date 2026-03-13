<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Setting model
 *
 * @property int $id
 * @property int $logo_orginal_id
 * @property int $logo_white_id
 * @property string $url_instagram
 * @property string $url_telegram
 * @property string $url_facebook
 * @property string $url_linkedIn
 * @property string $url_threads
 * @property string $url_discord
 * @property string $url_youtube
 * @property string $url_whatsapp
 * @property string $phone
 * @property int $count_employee
 * @property int $count_delivered
 * @property int $count_product_types
 * @property int $count_international_clients
 * @property string $about_name
 * @property string $about_description
 * @property string $name
 * @property string $other_phones
 * @property string $emails
 * @property string $address
 * @property int $language_id
 * @property string $company_name
 * @property string $questions
 *
 * @property Language $language
 * @property File $logoOrginal
 * @property File $logoWhite
 */
class Setting extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%setting}}';
    }

    public function rules()
    {
        return [
            [['language_id'], 'required'],
            [['language_id', 'logo_orginal_id', 'logo_white_id', 'count_employee', 'count_delivered', 'count_product_types', 'count_international_clients'], 'integer'],
            [['url_instagram', 'url_telegram', 'url_facebook', 'url_linkedIn', 'url_threads', 'url_discord', 'url_youtube', 'url_whatsapp', 'phone', 'about_name', 'name', 'company_name'], 'string', 'max' => 255],
            [['about_description', 'address'], 'string'],
            [['other_phones', 'emails', 'questions'], 'safe'],
            ['language_id', 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_id' => 'id']],
            ['language_id', 'unique', 'message' => 'Bu til uchun sozlama allaqachon mavjud'],
            ['logo_orginal_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['logo_orginal_id' => 'id']],
            ['logo_white_id', 'exist', 'skipOnError' => true, 'targetClass' => File::class, 'targetAttribute' => ['logo_white_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'logo_orginal_id' => 'Asosiy logo',
            'logo_white_id' => 'Oq logo',
            'url_instagram' => 'Instagram',
            'url_telegram' => 'Telegram',
            'url_facebook' => 'Facebook',
            'url_linkedIn' => 'LinkedIn',
            'url_threads' => 'Threads',
            'url_discord' => 'Discord',
            'url_youtube' => 'YouTube',
            'url_whatsapp' => 'WhatsApp',
            'phone' => 'Telefon',
            'count_employee' => 'Xodimlar soni',
            'count_delivered' => 'Yetkazilgan',
            'count_product_types' => 'Mahsulot turlari',
            'count_international_clients' => 'Xalqaro mijozlar',
            'about_name' => 'Haqida nomi',
            'about_description' => 'Haqida tavsif',
            'name' => 'Nomi',
            'company_name' => 'Kompaniya nomi',
            'questions' => 'Savollar',
            'other_phones' => 'Boshqa telefonlar',
            'emails' => 'Email lar',
            'address' => 'Manzil',
            'language_id' => 'Til',
        ];
    }

    public function fields()
    {
        $fields = parent::fields();

        unset($fields['language_id'], $fields['logo_orginal_id'], $fields['logo_white_id']);

        $fields['other_phones'] = function () {
            return $this->other_phones ? json_decode($this->other_phones, true) : null;
        };

        $fields['emails'] = function () {
            return $this->emails ? json_decode($this->emails, true) : null;
        };

        $fields['questions'] = function () {
            return $this->questions ? json_decode($this->questions, true) : null;
        };

        $fields['language_code'] = function () {
            return $this->language ? $this->language->code : null;
        };

        $fields['language_name'] = function () {
            return $this->language ? $this->language->name : null;
        };

        $fields['logo_orginal'] = function () {
            return $this->getFileData($this->logoOrginal);
        };

        $fields['logo_white'] = function () {
            return $this->getFileData($this->logoWhite);
        };

        return $fields;
    }

    protected function getFileData($file)
    {
        if (!$file) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $file->slug;
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'];
        $isImage = in_array(strtolower($file->exts), $imageExtensions);

        $data = [
            'id' => $file->id,
            'name' => $file->name,
            'slug' => $file->slug,
            'exts' => $file->exts,
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

    public function extraFields()
    {
        return ['language'];
    }

    public function getLanguage()
    {
        return $this->hasOne(Language::class, ['id' => 'language_id']);
    }

    public function getLogoOrginal()
    {
        return $this->hasOne(File::class, ['id' => 'logo_orginal_id']);
    }

    public function getLogoWhite()
    {
        return $this->hasOne(File::class, ['id' => 'logo_white_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if (is_array($this->other_phones)) {
                $this->other_phones = json_encode($this->other_phones, JSON_UNESCAPED_UNICODE);
            }
            if (is_array($this->emails)) {
                $this->emails = json_encode($this->emails, JSON_UNESCAPED_UNICODE);
            }
            if (is_array($this->questions)) {
                $this->questions = json_encode($this->questions, JSON_UNESCAPED_UNICODE);
            }
            return true;
        }
        return false;
    }

    /**
     * Til bo'yicha sozlamani topish yoki yaratish
     */
    public static function findOrCreateByLanguage($languageId)
    {
        $model = self::findOne(['language_id' => $languageId]);
        if (!$model) {
            $model = new self();
            $model->language_id = $languageId;
        }
        return $model;
    }
}
