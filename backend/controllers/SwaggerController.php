<?php

namespace backend\controllers;

use yii\web\Controller;
use yii\web\Response;
use Yii;

class SwaggerController extends Controller
{
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['cors'] = [
            'class' => \yii\filters\Cors::class,
        ];

        return $behaviors;
    }

    /**
     * Scalar API Reference sahifasi
     */
    public function actionIndex()
    {
        $this->layout = false;

        $swaggerJsonUrl = Yii::$app->request->hostInfo . '/api/swagger/json';

        return <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UZXCMG API</title>
</head>
<body>
    <script
        id="api-reference"
        data-url="{$swaggerJsonUrl}"
        data-configuration='{"theme":"purple"}'
    ></script>
    <script src="https://cdn.jsdelivr.net/npm/@scalar/api-reference"></script>
</body>
</html>
HTML;
    }

    /**
     * Swagger JSON generatsiya qilish
     */
    public function actionJson()
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $openapi = \OpenApi\Generator::scan([
            Yii::getAlias('@backend/swagger'),
        ]);

        return json_decode($openapi->toJson());
    }
}
