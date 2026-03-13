<?php

namespace backend\controllers\v1;

use common\models\Setting;
use common\models\Language;
use yii\web\NotFoundHttpException;
use Yii;

class SettingController extends BaseController
{
    // GET /v1/setting
    public function actionIndex()
    {
        $request = Yii::$app->request;

        $query = Setting::find()->with(['language', 'logoOrginal', 'logoWhite']);

        // Filter by language code
        if ($language = $request->get('language')) {
            $languageModel = Language::findOne(['code' => $language]);
            if ($languageModel) {
                $query->andFilterWhere(['language_id' => $languageModel->id]);
            }
        }

        return $query->all();
    }

    // GET /v1/setting/{id}
    public function actionView($id)
    {
        $model = Setting::find()
            ->where(['id' => $id])
            ->with(['language', 'logoOrginal', 'logoWhite'])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException("Sozlama topilmadi: $id");
        }

        return $model;
    }

    // GET /v1/setting/by-language?language=uz
    public function actionByLanguage()
    {
        $language = Yii::$app->request->get('language');

        if (!$language) {
            Yii::$app->response->statusCode = 400;
            return [
                'success' => false,
                'message' => 'Til kodi talab qilinadi',
            ];
        }

        $languageModel = Language::findOne(['code' => $language]);
        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $model = Setting::find()
            ->where(['language_id' => $languageModel->id])
            ->with(['language', 'logoOrginal', 'logoWhite'])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException("Bu til uchun sozlama topilmadi: $language");
        }

        return $model;
    }

    // POST /v1/setting - Yaratish yoki yangilash
    public function actionCreate()
    {
        $data = $this->prepareData(Yii::$app->request->post());

        // language code dan language_id ga
        if (isset($data['language']) && !empty($data['language'])) {
            $language = Language::findOne(['code' => $data['language']]);
            if ($language) {
                $data['language_id'] = $language->id;
            }
        }

        $languageId = $data['language_id'] ?? null;

        // Mavjud sozlamani tekshirish
        $model = Setting::findOne(['language_id' => $languageId]);

        if ($model) {
            // Mavjud bo'lsa - yangilash
            $model->load($data, '');

            if ($model->save()) {
                $model->refresh();
                $model->populateRelation('logoOrginal', $model->logoOrginal);
                $model->populateRelation('logoWhite', $model->logoWhite);
                return $model;
            }
        } else {
            // Yangi yaratish
            $model = new Setting();
            $model->load($data, '');

            if ($model->save()) {
                $model->refresh();
                $model->populateRelation('logoOrginal', $model->logoOrginal);
                $model->populateRelation('logoWhite', $model->logoWhite);
                Yii::$app->response->statusCode = 201;
                return $model;
            }
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }

    // PUT /v1/setting/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = $this->prepareData(Yii::$app->request->post());

        // language_id ni o'zgartirish mumkin emas
        unset($data['language_id'], $data['language']);

        $model->load($data, '');

        if ($model->save()) {
            $model->refresh();
            $model->populateRelation('logoOrginal', $model->logoOrginal);
            $model->populateRelation('logoWhite', $model->logoWhite);
            return $model;
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }

    protected function prepareData($data)
    {
        // language code dan language_id ga
        if (isset($data['language']) && !empty($data['language'])) {
            $language = Language::findOne(['code' => $data['language']]);
            if ($language) {
                $data['language_id'] = $language->id;
            }
        }

        return $data;
    }

    // DELETE /v1/setting/{id}
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if ($model->delete()) {
            Yii::$app->response->statusCode = 204;
            return null;
        }

        return [
            'success' => false,
            'message' => "O'chirib bo'lmadi",
        ];
    }

    protected function findModel($id)
    {
        $model = Setting::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Sozlama topilmadi: $id");
        }

        return $model;
    }
}
