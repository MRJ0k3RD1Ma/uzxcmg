<?php

namespace backend\controllers;

use common\models\File;
use common\models\LoginForm;
use Yii;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\Controller;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // CORS
        $behaviors['cors'] = [
            'class' => \yii\filters\Cors::class,
        ];

        $behaviors['access'] = [
            'class' => AccessControl::class,
            'rules' => [
                [
                    'actions' => ['login', 'error', 'options', 'file', 'home', 'category', 'navigation', 'article', 'article-view', 'media', 'category-products', 'product-view'],
                    'allow' => true,
                ],
                [
                    'actions' => ['logout', 'index'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];

        $behaviors['verbs'] = [
            'class' => VerbFilter::class,
            'actions' => [
                'logout' => ['post'],
            ],
        ];

        return $behaviors;
    }

    // OPTIONS preflight handler
    public function actionOptions()
    {
        Yii::$app->response->statusCode = 204;
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => \yii\web\ErrorAction::class,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return string|Response
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $this->layout = 'blank';

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Faylni yuklab olish yoki ko'rish
     *
     * @param string $slug Fayl slug
     * @param string $mode inline|download
     * @param string $size sm|md|lg (faqat rasmlar uchun)
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionFile($slug, $mode = 'inline', $size = 'lg')
    {
        $file = File::find()
            ->where(['slug' => $slug, 'status' => File::STATUS_ACTIVE])
            ->one();

        if (!$file) {
            throw new NotFoundHttpException('Fayl topilmadi');
        }

        // Rasm o'lchami bo'yicha URL olish
        switch ($size) {
            case 'sm':
                $fileUrl = $file->getSmallUrl();
                break;
            case 'md':
                $fileUrl = $file->getMediumUrl();
                break;
            default:
                $fileUrl = $file->getOriginalUrl();
        }

        $filePath = Yii::getAlias('@frontend/web') . $fileUrl;

        if (!file_exists($filePath)) {
            throw new NotFoundHttpException('Fayl serverda topilmadi');
        }

        $mimeType = mime_content_type($filePath) ?: 'application/octet-stream';
        $fileName = $file->name . '.' . $file->exts;

        return Yii::$app->response->sendFile($filePath, $fileName, [
            'mimeType' => $mimeType,
            'inline' => ($mode !== 'download'),
        ]);
    }

    /**
     * Home page ma'lumotlarini olish
     * GET /api/home/{language}
     *
     * @param string $language Til kodi (uz, ru, en)
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionHome($language)
    {
        $languageModel = \common\models\Language::find()
            ->where(['code' => $language, 'status' => \common\models\Language::STATUS_ACTIVE])
            ->one();

        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $languageId = $languageModel->id;

        // Navigation - daraxt ko'rinishda
        $navigation = $this->getNavigationTree($languageId);

        // Category - daraxt ko'rinishda
        $category = $this->getCategoryTree($languageId);

        // Article - 4 ta eng oxirgi
        $articles = \common\models\Article::find()
            ->where(['language_id' => $languageId, 'status' => \common\models\Article::STATUS_ACTIVE])
            ->orderBy(['id' => SORT_DESC])
            ->limit(4)
            ->with(['navigation', 'image', 'language'])
            ->all();

        // Setting - joriy til uchun
        $setting = \common\models\Setting::find()
            ->where(['language_id' => $languageId])
            ->with(['language', 'logoOrginal', 'logoWhite'])
            ->one();

        return [
            'navigation' => $navigation,
            'category' => $category,
            'articles' => $articles,
            'setting' => $setting,
        ];
    }

    /**
     * Navigation daraxtini olish
     */
    private function getNavigationTree($languageId)
    {
        $navigations = \common\models\Navigation::find()
            ->alias('n')
            ->select([
                'n.id',
                'n.parent_id',
                'n.name',
                'n.slug',
                'n.icon',
                'n.image_id',
                'n.template',
                'n.category_id',
                'n.extra_url',
                'n.sort_order',
                'n.status',
                'n.created',
                'n.updated',
                'language_code' => 'l.code',
                'language_name' => 'l.name',
                'file_id' => 'f.id',
                'file_slug' => 'f.slug',
                'file_exts' => 'f.exts',
                'file_status' => 'f.status',
                'file_url' => 'f.url',
            ])
            ->leftJoin('{{%language}} l', 'n.language_id = l.id')
            ->leftJoin('{{%files}} f', 'n.image_id = f.id')
            ->where(['n.status' => \common\models\Navigation::STATUS_ACTIVE, 'n.language_id' => $languageId])
            ->orderBy(['n.sort_order' => SORT_ASC])
            ->asArray()
            ->all();

        return $this->buildNavigationTree($navigations);
    }

    /**
     * Navigation daraxtini shakllantirish
     */
    private function buildNavigationTree(array $navigations, $parentId = null)
    {
        $tree = [];
        foreach ($navigations as $navigation) {
            if ($navigation['parent_id'] == $parentId) {
                // Image ma'lumotlarini formatlash
                $navigation['image'] = $this->formatImageData($navigation);

                // Category ma'lumotlarini qo'shish
                if (!empty($navigation['category_id'])) {
                    $category = \common\models\Category::findOne($navigation['category_id']);
                    if ($category) {
                        $navigation['category'] = [
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                        ];
                    }
                } else {
                    $navigation['category'] = null;
                }

                // Keraksiz fieldlarni olib tashlash
                unset(
                    $navigation['image_id'],
                    $navigation['file_id'],
                    $navigation['file_slug'],
                    $navigation['file_exts'],
                    $navigation['file_status'],
                    $navigation['file_url'],
                    $navigation['category_id']
                );

                $children = $this->buildNavigationTree($navigations, $navigation['id']);
                if ($children) {
                    $navigation['children'] = $children;
                }
                $tree[] = $navigation;
            }
        }
        return $tree;
    }

    /**
     * Category daraxtini olish
     */
    private function getCategoryTree($languageId)
    {
        $categories = \common\models\Category::find()
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
                'file_id' => 'f.id',
                'file_slug' => 'f.slug',
                'file_exts' => 'f.exts',
                'file_status' => 'f.status',
                'file_url' => 'f.url',
            ])
            ->leftJoin('{{%language}} l', 'c.language_id = l.id')
            ->leftJoin('{{%files}} f', 'c.image_id = f.id')
            ->where(['c.status' => \common\models\Category::STATUS_ACTIVE, 'c.language_id' => $languageId])
            ->orderBy(['c.sort_order' => SORT_ASC])
            ->asArray()
            ->all();

        return $this->buildCategoryTree($categories);
    }

    /**
     * Category daraxtini shakllantirish
     */
    private function buildCategoryTree(array $categories, $parentId = null)
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

                $children = $this->buildCategoryTree($categories, $category['id']);
                if ($children) {
                    $category['children'] = $children;
                }
                $tree[] = $category;
            }
        }
        return $tree;
    }

    /**
     * Image ma'lumotlarini formatlash
     */
    private function formatImageData($data)
    {
        if (empty($data['file_id'])) {
            return null;
        }

        $baseUrl = '/api/v1/getfile/' . $data['file_slug'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $isImage = in_array(strtolower($data['file_exts']), $imageExtensions);

        $imageData = [
            'id' => (int)$data['file_id'],
            'status' => $data['file_status'] == File::STATUS_ACTIVE ? 'ACTIVE' : 'INACTIVE',
            'slug' => $data['file_slug'],
            'exts' => $data['file_exts'],
            'download_url' => $baseUrl,
            'download' => null,
            'url' => null,
        ];

        if ($isImage && $data['file_url']) {
            $urls = json_decode($data['file_url'], true);
            $imageData['download'] = [
                'sm' => $baseUrl . '?size=sm',
                'md' => $baseUrl . '?size=md',
                'lg' => $baseUrl . '?size=lg',
            ];
            $imageData['url'] = [
                'sm' => $urls['small'] ?? null,
                'md' => $urls['medium'] ?? null,
                'lg' => $urls['original'] ?? null,
            ];
        }

        return $imageData;
    }

    /**
     * Category daraxtini olish
     * GET /api/category/{language}
     *
     * @param string $language Til kodi (uz, ru, en)
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionCategory($language)
    {
        $languageModel = \common\models\Language::find()
            ->where(['code' => $language, 'status' => \common\models\Language::STATUS_ACTIVE])
            ->one();

        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $languageId = $languageModel->id;

        // Category - daraxt ko'rinishda
        $category = $this->getCategoryTree($languageId);

        return [
            'data' => $category,
        ];
    }

    /**
     * Navigation daraxtini olish
     * GET /api/navigation/{language}
     *
     * @param string $language Til kodi (uz, ru, en)
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionNavigation($language)
    {
        $languageModel = \common\models\Language::find()
            ->where(['code' => $language, 'status' => \common\models\Language::STATUS_ACTIVE])
            ->one();

        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $languageId = $languageModel->id;

        // Navigation - daraxt ko'rinishda
        $navigation = $this->getNavigationTree($languageId);

        return [
            'data' => $navigation,
        ];
    }

    /**
     * Bitta maqolani slug bo'yicha olish
     * GET /api/article/{language}/{slug}
     *
     * @param string $language Til kodi (uz, ru, en)
     * @param string $slug Article slug
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionArticleView($language, $slug)
    {
        $languageModel = \common\models\Language::find()
            ->where(['code' => $language, 'status' => \common\models\Language::STATUS_ACTIVE])
            ->one();

        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $article = \common\models\Article::find()
            ->where([
                'slug'        => $slug,
                'language_id' => $languageModel->id,
                'status'      => \common\models\Article::STATUS_ACTIVE,
            ])
            ->with(['navigation', 'image', 'language'])
            ->one();

        if (!$article) {
            throw new NotFoundHttpException("Maqola topilmadi: $slug");
        }

        $article->incrementCounter();

        return [
            'data' => $article,
        ];
    }

    /**
     * Media type slug bo'yicha medialar ro'yxatini olish
     * GET /api/media/{slug}
     *
     * @param string $slug MediaType slug
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionMedia($slug)
    {
        $mediaType = \common\models\MediaType::find()
            ->where(['slug' => $slug, 'status' => \common\models\MediaType::STATUS_ACTIVE])
            ->one();

        if (!$mediaType) {
            throw new NotFoundHttpException("Media turi topilmadi: $slug");
        }

        $request = Yii::$app->request;
        $limit = (int)$request->get('limit', 20);

        $query = \common\models\Media::find()
            ->where([
                'type_id' => $mediaType->id,
                'status'  => \common\models\Media::STATUS_ACTIVE,
            ])
            ->with(['file'])
            ->orderBy(['id' => SORT_DESC])
            ->limit($limit);

        return [
            'type' => $mediaType,
            'data' => $query->all(),
        ];
    }

    /**
     * Bitta productni slug bo'yicha olish
     * GET /api/product/{language}/{slug}
     *
     * @param string $language Til kodi (uz, ru)
     * @param string $slug Product slug
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionProductView($language, $slug)
    {
        $languageModel = \common\models\Language::find()
            ->where(['code' => $language, 'status' => \common\models\Language::STATUS_ACTIVE])
            ->one();

        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $product = \common\models\Product::find()
            ->where([
                'slug'        => $slug,
                'language_id' => $languageModel->id,
                'status'      => \common\models\Product::STATUS_ACTIVE,
            ])
            ->with(['category', 'image', 'language', 'images', 'guides', 'softs'])
            ->one();

        if (!$product) {
            throw new NotFoundHttpException("Product topilmadi: $slug");
        }

        return [
            'data' => $product,
        ];
    }

    /**
     * Kategoriyaga tegishli productlarni olish
     * GET /api/products/{language}/{slug}
     *
     * @param string $language Til kodi (uz, ru)
     * @param string $slug Category slug
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionCategoryProducts($language, $slug)
    {
        $languageModel = \common\models\Language::find()
            ->where(['code' => $language, 'status' => \common\models\Language::STATUS_ACTIVE])
            ->one();

        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $category = \common\models\Category::find()
            ->where(['slug' => $slug, 'language_id' => $languageModel->id, 'status' => \common\models\Category::STATUS_ACTIVE])
            ->one();

        if (!$category) {
            throw new NotFoundHttpException("Kategoriya topilmadi: $slug");
        }

        $request = Yii::$app->request;
        $perPage  = (int)$request->get('per_page', 20);
        $page     = max(1, (int)$request->get('page', 1));

        $query = \common\models\Product::find()
            ->where([
                'category_id' => $category->id,
                'language_id' => $languageModel->id,
                'status'      => \common\models\Product::STATUS_ACTIVE,
            ])
            ->with(['category', 'image', 'language']);

        if ($search = $request->get('search')) {
            $query->andWhere(['or',
                ['like', 'name', $search],
                ['like', 'description', $search],
                ['like', 'sku', $search],
            ]);
        }

        if ($featured = $request->get('featured')) {
            $query->andWhere(['featured' => (int)$featured]);
        }

        $totalItems = (clone $query)->count();
        $totalPages = ceil($totalItems / $perPage);

        $products = $query
            ->orderBy(['id' => SORT_DESC])
            ->limit($perPage)
            ->offset(($page - 1) * $perPage)
            ->all();

        return [
            'category'   => $category,
            'data'       => $products,
            'pagination' => [
                'current_page' => $page,
                'per_page'     => $perPage,
                'total_items'  => (int)$totalItems,
                'total_pages'  => (int)$totalPages,
                'has_next'     => $page < $totalPages,
                'has_prev'     => $page > 1,
            ],
        ];
    }

    /**
     * Article yoki articlelar ro'yxatini olish
     * GET /api/article/{language}/{slug}
     *
     * @param string $language Til kodi (uz, ru, en)
     * @param string $slug Navigation slug
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionArticle($language, $slug)
    {
        // Language topish
        $languageModel = \common\models\Language::find()
            ->where(['code' => $language, 'status' => \common\models\Language::STATUS_ACTIVE])
            ->one();

        if (!$languageModel) {
            throw new NotFoundHttpException("Til topilmadi: $language");
        }

        $languageId = $languageModel->id;

        // Navigation topish
        $navigation = \common\models\Navigation::find()
            ->where(['slug' => $slug, 'language_id' => $languageId, 'status' => \common\models\Navigation::STATUS_ACTIVE])
            ->one();

        if (!$navigation) {
            throw new NotFoundHttpException("Navigatsiya topilmadi: $slug");
        }

        $request = Yii::$app->request;
        $perPage = (int)$request->get('per_page', 13);

        // Template turiga qarab ishlash
        if ($navigation->template === \common\models\Navigation::TEMPLATE_SINGLE) {
            // SINGLE - 1 ta article qaytarish
            $article = \common\models\Article::find()
                ->where([
                    'navigation_id' => $navigation->id,
                    'language_id' => $languageId,
                    'status' => \common\models\Article::STATUS_ACTIVE
                ])
                ->orderBy(['id' => SORT_DESC])
                ->with(['navigation', 'image', 'language'])
                ->one();

            if (!$article) {
                throw new NotFoundHttpException("Maqola topilmadi");
            }

            return [
                'data' => $article,
                'navigation' => $navigation,
            ];
        } else {
            // LIST - articlelar ro'yxati pagination bilan
            $query = \common\models\Article::find()
                ->where([
                    'navigation_id' => $navigation->id,
                    'language_id' => $languageId,
                    'status' => \common\models\Article::STATUS_ACTIVE
                ]);

            // Global search
            if ($search = $request->get('search')) {
                $query->andWhere([
                    'or',
                    ['like', 'name', $search],
                    ['like', 'description', $search],
                ]);
            }

            $query->with(['navigation', 'image', 'language']);

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
                'navigation' => $navigation,
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
    }
}
