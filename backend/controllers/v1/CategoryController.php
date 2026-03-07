<?php

namespace backend\controllers\v1;

use common\models\Category;
use common\models\Language;
use common\models\File;
use yii\web\NotFoundHttpException;
use Yii;

class CategoryController extends BaseController
{
    // GET /v1/category
    public function actionIndex()
    {
        $request = Yii::$app->request;
        $perPage = (int)$request->get('per_page', 20);

        $query = Category::find()->andWhere(['status'=>1]);

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

    // GET /v1/category/tree - daraxt ko'rinishda
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

            $categories = $this->getCategoriesWithLanguage($language->id);
            return $this->buildTree($categories);
        }

        // Language berilmagan bo'lsa, barcha tillar uchun alohida tree
        $languages = Language::find()
            ->where(['status' => Language::STATUS_ACTIVE])
            ->all();

        $result = [];
        foreach ($languages as $language) {
            $categories = $this->getCategoriesWithLanguage($language->id);
            $result[$language->code] = $this->buildTree($categories);
        }

        return $result;
    }

    private function getCategoriesWithLanguage($languageId)
    {
        return Category::find()
            ->alias('c')
            ->select([
                'c.id',
                'c.parent_id',
                'c.name',
                'c.slug',
                'c.icon',
                'c.image_id',
                'c.spec_template',
                'c.sort_order',
                'c.status',
                'c.created',
                'c.updated',
                'language_code' => 'l.code',
                'language_name' => 'l.name',
                // File ma'lumotlari
                'file_id' => 'f.id',
                'file_slug' => 'f.slug',
                'file_exts' => 'f.exts',
                'file_status' => 'f.status',
                'file_url' => 'f.url',
            ])
            ->leftJoin('{{%language}} l', 'c.language_id = l.id')
            ->leftJoin('{{%files}} f', 'c.image_id = f.id')
            ->where(['c.status' => Category::STATUS_ACTIVE, 'c.language_id' => $languageId])
            ->orderBy(['c.sort_order' => SORT_ASC])
            ->asArray()
            ->all();
    }

    private function buildTree(array $categories, $parentId = null)
    {
        $tree = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == $parentId) {
                // Image ma'lumotlarini formatlash
                $category['image'] = $this->formatImageData($category);

                // spec_template ni JSON formatda qaytarish
                $category['spec_template'] = $category['spec_template']
                    ? json_decode($category['spec_template'], true)
                    : null;

                // Keraksiz fieldlarni olib tashlash
                unset(
                    $category['image_id'],
                    $category['file_id'],
                    $category['file_slug'],
                    $category['file_exts'],
                    $category['file_status'],
                    $category['file_url']
                );

                $children = $this->buildTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $tree[] = $category;
            }
        }
        return $tree;
    }

    private function formatImageData($category)
    {
        if (empty($category['file_id'])) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $category['file_slug'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $isImage = in_array(strtolower($category['file_exts']), $imageExtensions);

        $data = [
            'id' => (int)$category['file_id'],
            'status' => $category['file_status'] == File::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE',
            'slug' => $category['file_slug'],
            'exts' => $category['file_exts'],
            'download_url' => $baseUrl,
            'download' => null,
            'url' => null,
        ];

        if ($isImage && $category['file_url']) {
            $urls = json_decode($category['file_url'], true);
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

    // GET /v1/category/{id}
    public function actionView($id)
    {
        return $this->findModel($id);
    }

    // POST /v1/category
    public function actionCreate()
    {
        $model = new Category();
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

    // PUT/POST /v1/category/{id}
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

        // Bo'sh parent_id ni null ga
        if (isset($data['parent_id']) && $data['parent_id'] === '') {
            $data['parent_id'] = null;
        }

        return $data;
    }

    // DELETE /v1/category/{id}
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Category::STATUS_INACTIVE;

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
        $model = Category::findOne($id);

        if ($model === null) {
            throw new NotFoundHttpException("Kategoriya topilmadi: $id");
        }

        return $model;
    }
}
