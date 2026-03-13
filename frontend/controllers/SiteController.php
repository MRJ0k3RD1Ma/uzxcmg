<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\filters\Cors;
use common\models\LoginForm;
use common\models\Language;
use common\models\Navigation;
use common\models\Banner;
use common\models\Partner;
use common\models\Category;
use common\models\Setting;
use common\models\Article;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'cors' => [
                'class' => Cors::class,
            ],
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
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
            'captcha' => [
                'class' => \yii\captcha\CaptchaAction::class,
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

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
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        }

        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            }

            Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($model->verifyEmail()) {
            Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
            return $this->goHome();
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->goHome();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

    /**
     * OPTIONS preflight request uchun
     */
    public function actionOptions()
    {
        Yii::$app->response->statusCode = 200;
        return '';
    }

    /**
     * Home page data - public API
     * GET /site/home?language=uz
     *
     * @param string $language Til kodi (uz, ru, en)
     * @return array
     */
    public function actionHome($language = 'uz')
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        // Tilni topish
        $languageModel = Language::findOne(['code' => $language, 'status' => Language::STATUS_ACTIVE]);

        if (!$languageModel) {
            Yii::$app->response->statusCode = 404;
            return [
                'success' => false,
                'message' => "Til topilmadi: $language",
            ];
        }

        $languageId = $languageModel->id;

        // Navigatsiyalar (tree structure)
        $navigations = Navigation::find()
            ->where(['language_id' => $languageId, 'status' => Navigation::STATUS_ACTIVE, 'parent_id' => null])
            ->with(['image', 'children' => function ($query) {
                $query->where(['status' => Navigation::STATUS_ACTIVE])
                    ->orderBy(['sort_order' => SORT_ASC]);
            }])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        // Bannerlar
        $banners = Banner::find()
            ->where(['language_id' => $languageId, 'status' => Banner::STATUS_ACTIVE])
            ->with(['image'])
            ->all();

        // Hamkorlar
        $partners = Partner::find()
            ->where(['language_id' => $languageId, 'status' => Partner::STATUS_ACTIVE])
            ->with(['image'])
            ->all();

        // Kategoriyalar (tree structure)
        $categories = Category::find()
            ->where(['language_id' => $languageId, 'status' => Category::STATUS_ACTIVE, 'parent_id' => null])
            ->with(['image', 'children' => function ($query) {
                $query->where(['status' => Category::STATUS_ACTIVE])
                    ->orderBy(['sort_order' => SORT_ASC]);
            }])
            ->orderBy(['sort_order' => SORT_ASC])
            ->all();

        // Sozlamalar
        $setting = Setting::find()
            ->where(['language_id' => $languageId])
            ->with(['logoOrginal', 'logoWhite'])
            ->one();

        // 4 ta so'nggi maqola
        $articles = Article::find()
            ->where(['language_id' => $languageId, 'status' => Article::STATUS_ACTIVE])
            ->with(['image', 'navigation'])
            ->orderBy(['id' => SORT_DESC])
            ->limit(4)
            ->all();

        return [
            'success' => true,
            'language' => [
                'code' => $languageModel->code,
                'name' => $languageModel->name,
            ],
            'navigations' => $this->formatNavigations($navigations),
            'banners' => $banners,
            'partners' => $partners,
            'categories' => $this->formatCategories($categories),
            'setting' => $setting,
            'articles' => $articles,
        ];
    }

    /**
     * Navigatsiyalarni formatlash (children bilan)
     */
    protected function formatNavigations($navigations)
    {
        $result = [];
        foreach ($navigations as $nav) {
            $item = $nav->toArray();
            $item['children'] = [];
            foreach ($nav->children as $child) {
                $item['children'][] = $child->toArray();
            }
            $result[] = $item;
        }
        return $result;
    }

    /**
     * Kategoriyalarni formatlash (children bilan)
     */
    protected function formatCategories($categories)
    {
        $result = [];
        foreach ($categories as $cat) {
            $item = $cat->toArray();
            $item['children'] = [];
            foreach ($cat->children as $child) {
                $item['children'][] = $child->toArray();
            }
            $result[] = $item;
        }
        return $result;
    }
}
