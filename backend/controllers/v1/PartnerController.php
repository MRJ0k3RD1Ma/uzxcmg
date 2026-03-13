<?php

namespace backend\controllers\v1;

use common\models\Partner;
use common\models\Language;
use yii\web\NotFoundHttpException;
use Yii;

class PartnerController extends BaseController
{
    // GET /v1/partner
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $perPage = (int)$request->get('per_page', 20);

        $query = Partner::find()->andWhere(['status' => 1]);

        // Filter by language code
        if ($language = $request->get('language')) {
            $languageModel = Language::findOne(['code' => $language]);
            if ($languageModel) {
                $query->andFilterWhere(['language_id' => $languageModel->id]);
            }
        }

        // Filter by status
        if (($status = $request->get('status')) !== null) {
            $query->andFilterWhere(['status' => $status]);
        }

        // Global search
        if ($search = $request->get('search')) {
            $query->andWhere(['like', 'name', $search]);
        }

        // Expand relations
        if ($expand = $request->get('expand')) {
            $query->with(explode(',', $expand));
        }

        $provider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
            'pagination' => [
                'pageSize' => $perPage,
                'pageParam' => 'page',
                'pageSizeParam' => 'per_page',
            ],
        ]);

        $pagination = $provider->pagination;
        $totalItems = $provider->totalCount;
        $totalPages = ceil($totalItems / $perPage);
        $currentPage = $pagination->page + 1;

        return [
            'data' => $provider->getModels(),
            'pagination' => [
                'current_page' => $currentPage,
                'per_page' => $perPage,
                'total_items' => $totalItems,
                'total_pages' => $totalPages,
                'has_next' => $currentPage < $totalPages,
                'has_prev' => $currentPage > 1,
            ],
        ];
    }

    // GET /v1/partner/{id}
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    // POST /v1/partner
    public function actionCreate()
    {
        $model = new Partner();
        $data = $this->prepareData(Yii::$app->request->post());
        $model->load($data, '');

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            return $model;
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }

    // PUT/POST /v1/partner/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = $this->prepareData(Yii::$app->request->post());
        $model->load($data, '');

        if ($model->save()) {
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

    // DELETE /v1/partner/{id}
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Partner::STATUS_INACTIVE;

        if ($model->save(false)) {
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
        $model = Partner::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Hamkor topilmadi: $id");
        }

        return $model;
    }
}
