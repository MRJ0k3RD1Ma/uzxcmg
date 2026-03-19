<?php

namespace backend\controllers\v1;

use common\models\Media;
use yii\web\NotFoundHttpException;
use Yii;

class MediaController extends BaseController
{
    // GET /v1/media
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $perPage = (int)$request->get('per_page', 20);

        $query = Media::find()->with(['file', 'mediaType']);

        if (($status = $request->get('status')) !== null) {
            $query->andFilterWhere(['status' => $status]);
        }

        if (($typeId = $request->get('type_id')) !== null) {
            $query->andFilterWhere(['type_id' => $typeId]);
        }

        if (($hasUrl = $request->get('has_url')) !== null) {
            $query->andFilterWhere(['has_url' => $hasUrl]);
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

    // GET /v1/media/{id}
    public function actionView($id)
    {
        $model = Media::find()
            ->where(['id' => $id])
            ->with(['file', 'mediaType'])
            ->one();

        if ($model === null) {
            throw new NotFoundHttpException("Media topilmadi: $id");
        }

        return $model;
    }

    // POST /v1/media
    public function actionCreate()
    {
        $model = new Media();
        $model->load(Yii::$app->request->post(), '');

        if ($model->save()) {
            $model->refresh();
            $model->populateRelation('file', $model->file);
            $model->populateRelation('mediaType', $model->mediaType);
            Yii::$app->response->statusCode = 201;
            return $model;
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors'  => $model->errors,
        ];
    }

    // PUT /v1/media/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->request->post(), '');

        if ($model->save()) {
            $model->refresh();
            $model->populateRelation('file', $model->file);
            $model->populateRelation('mediaType', $model->mediaType);
            return $model;
        }

        Yii::$app->response->statusCode = 400;
        return [
            'success' => false,
            'errors'  => $model->errors,
        ];
    }

    // DELETE /v1/media/{id}
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Media::STATUS_INACTIVE;

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
        $model = Media::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Media topilmadi: $id");
        }

        return $model;
    }
}
