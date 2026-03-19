<?php

namespace backend\controllers\v1;

use common\models\MediaType;
use yii\web\NotFoundHttpException;
use Yii;

class MediaTypeController extends BaseController
{
    // GET /v1/media-type
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $perPage = (int)$request->get('per_page', 20);

        $query = MediaType::find();

        if (($status = $request->get('status')) !== null) {
            $query->andFilterWhere(['status' => $status]);
        }

        if ($search = $request->get('search')) {
            $query->andWhere(['like', 'name', $search]);
        }

        $provider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
                'attributes' => ['id', 'name', 'created'],
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
                'per_page'     => $perPage,
                'total_items'  => $totalItems,
                'total_pages'  => $totalPages,
                'has_next'     => $currentPage < $totalPages,
                'has_prev'     => $currentPage > 1,
            ],
        ];
    }

    // GET /v1/media-type/{id}
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    // POST /v1/media-type
    public function actionCreate()
    {
        $model = new MediaType();
        $model->load(Yii::$app->request->post(), '');

        if ($model->save()) {
            Yii::$app->response->statusCode = 201;
            return $model;
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors'  => $model->errors,
        ];
    }

    // PUT /v1/media-type/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');

        if ($model->save()) {
            return $model;
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors'  => $model->errors,
        ];
    }

    // DELETE /v1/media-type/{id}
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = MediaType::STATUS_INACTIVE;

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
        $model = MediaType::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Media turi topilmadi: $id");
        }

        return $model;
    }
}
