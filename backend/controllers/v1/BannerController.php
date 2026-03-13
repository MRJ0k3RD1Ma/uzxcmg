<?php

namespace backend\controllers\v1;

use common\models\Banner;
use common\models\Language;
use yii\web\NotFoundHttpException;
use Yii;

class BannerController extends BaseController
{
    // GET /v1/banner
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $perPage = (int)$request->get('per_page', 20);

        $query = Banner::find()->with(['image', 'language']);

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
        } else {
            $query->andWhere(['status' => Banner::STATUS_ACTIVE]);
        }

        // Global search
        if ($search = $request->get('search')) {
            $query->andWhere([
                'or',
                ['like', 'name', $search],
                ['like', 'description', $search],
            ]);
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

    // GET /v1/banner/{id}
    public function actionView($id)
    {
        $model = Banner::find()
            ->where(['id' => $id])
            ->with(['image', 'language'])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException("Banner topilmadi: $id");
        }

        return $model;
    }

    // POST /v1/banner
    public function actionCreate()
    {
        $model = new Banner();
        $data = $this->prepareData(Yii::$app->request->post());
        $model->load($data, '');

        if ($model->save()) {
            $model->refresh();
            $model->populateRelation('image', $model->image);
            Yii::$app->response->statusCode = 201;
            return $model;
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors' => $model->errors,
        ];
    }

    // PUT/POST /v1/banner/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = $this->prepareData(Yii::$app->request->post());
        $model->load($data, '');

        if ($model->save()) {
            $model->refresh();
            $model->populateRelation('image', $model->image);
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

    // DELETE /v1/banner/{id}
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Banner::STATUS_INACTIVE;

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
        $model = Banner::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Banner topilmadi: $id");
        }

        return $model;
    }
}
