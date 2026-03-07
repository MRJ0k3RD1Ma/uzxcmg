<?php

namespace backend\controllers\v1;

use common\models\Navigation;
use common\models\Language;
use common\models\File;
use yii\web\NotFoundHttpException;
use Yii;

class NavigationController extends BaseController
{
    // GET /v1/navigation
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $perPage = (int)$request->get('per_page', 20);

        $query = Navigation::find()->andWhere(['status' => 1]);

        // Search by name
        if ($name = $request->get('name')) {
            $query->andFilterWhere(['like', 'name', $name]);
        }

        // Filter by parent_id
        if (($parentId = $request->get('parent_id')) !== null) {
            $query->andFilterWhere(['parent_id' => $parentId]);
        }

        // Filter by language code
        if ($language = $request->get('language')) {
            $languageModel = Language::findOne(['code' => $language]);
            if ($languageModel) {
                $query->andFilterWhere(['language_id' => $languageModel->id]);
            }
        }

        // Filter by template
        if ($template = $request->get('template')) {
            $query->andFilterWhere(['template' => $template]);
        }

        // Filter by status
        if (($status = $request->get('status')) !== null) {
            $query->andFilterWhere(['status' => $status]);
        }

        // Global search
        if ($search = $request->get('search')) {
            $query->andWhere(['like', 'name', $search]);
        }

        $provider = new \yii\data\ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => ['sort_order' => SORT_ASC, 'id' => SORT_DESC],
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

    // GET /v1/navigation/tree - daraxt ko'rinishda
    public function actionTree()
    {
        $request = Yii::$app->request;
        $languageCode = $request->get('language');

        // Agar language berilgan bo'lsa, faqat shu til uchun tree
        if ($languageCode) {
            $language = Language::findOne(['code' => $languageCode]);
            if (!$language) {
                Yii::$app->response->statusCode = 404;
                return [
                    'success' => false,
                    'message' => "Til topilmadi: $languageCode",
                ];
            }

            $navigations = $this->getNavigationsWithLanguage($language->id);
            return $this->buildTree($navigations);
        }

        // Language berilmagan bo'lsa, barcha tillar uchun alohida tree
        $languages = Language::find()
            ->where(['status' => Language::STATUS_ACTIVE])
            ->all();

        $result = [];
        foreach ($languages as $language) {
            $navigations = $this->getNavigationsWithLanguage($language->id);
            $result[$language->code] = $this->buildTree($navigations);
        }

        return $result;
    }

    private function getNavigationsWithLanguage($languageId)
    {
        return Navigation::find()
            ->alias('n')
            ->select([
                'n.id',
                'n.name',
                'n.slug',
                'n.icon',
                'n.image_id',
                'n.template',
                'n.parent_id',
                'n.sort_order',
                'n.status',
                'n.created',
                'n.updated',
                'n.category_id',
                'n.extra_url',
                'language_code' => 'l.code',
                'language_name' => 'l.name',
                // File ma'lumotlari
                'file_id' => 'f.id',
                'file_slug' => 'f.slug',
                'file_exts' => 'f.exts',
                'file_status' => 'f.status',
                'file_url' => 'f.url',
            ])
            ->leftJoin('{{%language}} l', 'n.language_id = l.id')
            ->leftJoin('{{%files}} f', 'n.image_id = f.id')
            ->where(['n.status' => Navigation::STATUS_ACTIVE, 'n.language_id' => $languageId])
            ->orderBy(['n.sort_order' => SORT_ASC])
            ->asArray()
            ->all();
    }

    private function buildTree(array $navigations, $parentId = null)
    {
        $tree = [];
        foreach ($navigations as $navigation) {
            if ($navigation['parent_id'] == $parentId) {
                // Image ma'lumotlarini formatlash
                $navigation['image'] = $this->formatImageData($navigation);

                // Keraksiz fieldlarni olib tashlash
                unset(
                    $navigation['image_id'],
                    $navigation['file_id'],
                    $navigation['file_slug'],
                    $navigation['file_exts'],
                    $navigation['file_status'],
                    $navigation['file_url']
                );

                $children = $this->buildTree($navigations, $navigation['id']);
                if ($children) {
                    $navigation['children'] = $children;
                }
                $tree[] = $navigation;
            }
        }
        return $tree;
    }

    private function formatImageData($navigation)
    {
        if (empty($navigation['file_id'])) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $navigation['file_slug'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $isImage = in_array(strtolower($navigation['file_exts']), $imageExtensions);

        $data = [
            'id' => (int)$navigation['file_id'],
            'status' => $navigation['file_status'] == File::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE',
            'slug' => $navigation['file_slug'],
            'exts' => $navigation['file_exts'],
            'download_url' => $baseUrl,
            'download' => null,
            'url' => null,
        ];

        if ($isImage && $navigation['file_url']) {
            $urls = json_decode($navigation['file_url'], true);
            $data['download'] = [
                'sm' => $baseUrl . '?size=sm',
                'md' => $baseUrl . '?size=md',
                'lg' => $baseUrl . '?size=lg',
            ];
            $data['url'] = [
                'sm' => $urls['small'] ?? null,
                'md' => $urls['medium'] ?? null,
                'lg' => $urls['original'] ?? null,
            ];
        }

        return $data;
    }

    // GET /v1/navigation/{id}
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    // POST /v1/navigation
    public function actionCreate()
    {
        $model = new Navigation();
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

    // PUT/POST /v1/navigation/{id}
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $data = $this->prepareData(Yii::$app->request->post(), $id);
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

    protected function prepareData($data, $navigationId = null)
    {
        // name_uz yoki name_ru dan name ga
        if (isset($data['name_uz'])) {
            $data['name'] = $data['name_uz'];
        } elseif (isset($data['name_ru'])) {
            $data['name'] = $data['name_ru'];
        }

        // language code dan language_id ga
        if (isset($data['language']) && !empty($data['language'])) {
            $language = Language::findOne(['code' => $data['language']]);
            if ($language) {
                $data['language_id'] = $language->id;
            }
        }

        // Bo'sh parent_id ni null ga
        if (isset($data['parent_id']) && $data['parent_id'] === '') {
            $data['parent_id'] = null;
        }

        // is_extra asosida template ni aniqlash
        if (isset($data['is_extra']) && ($data['is_extra'] === true || $data['is_extra'] === 'true' || $data['is_extra'] === 1 || $data['is_extra'] === '1')) {
            $data['template'] = Navigation::TEMPLATE_EXTRA;
            unset($data['is_extra'], $data['is_category']);
            return $data;
        }
        unset($data['is_extra']);

        // is_category asosida template ni aniqlash
        if (isset($data['is_category'])) {
            if ($data['is_category'] === true || $data['is_category'] === 'true' || $data['is_category'] === 1 || $data['is_category'] === '1') {
                $data['template'] = Navigation::TEMPLATE_CATEGORY;
            } else {
                // Article soniga qarab SINGLE yoki LIST
                $data['template'] = $this->determineTemplate($navigationId);
            }
            unset($data['is_category']);
        }

        return $data;
    }

    protected function determineTemplate($navigationId)
    {
        if (!$navigationId) {
            return Navigation::TEMPLATE_SINGLE;
        }

        $articleCount = \common\models\Article::find()
            ->where(['navigation_id' => $navigationId, 'status' => \common\models\Article::STATUS_ACTIVE])
            ->count();

        return $articleCount > 1 ? Navigation::TEMPLATE_LIST : Navigation::TEMPLATE_SINGLE;
    }

    // DELETE /v1/navigation/{id}
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Navigation::STATUS_INACTIVE;

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
        $model = Navigation::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Navigation topilmadi: $id");
        }

        return $model;
    }
}
