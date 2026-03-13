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
     * Swagger UI sahifasi
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
    <title>UZXCMG API - Swagger UI</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui.css">
    <style>
        html { box-sizing: border-box; overflow-y: scroll; }
        *, *:before, *:after { box-sizing: inherit; }
        body { margin: 0; background: #fafafa; }
        .swagger-ui .topbar { display: none; }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>
    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-bundle.js"></script>
    <script src="https://unpkg.com/swagger-ui-dist@4.15.5/swagger-ui-standalone-preset.js"></script>
    <script>
        window.onload = function() {
            const ui = SwaggerUIBundle({
                url: "{$swaggerJsonUrl}",
                dom_id: '#swagger-ui',
                deepLinking: true,
                presets: [
                    SwaggerUIBundle.presets.apis,
                    SwaggerUIStandalonePreset
                ],
                plugins: [
                    SwaggerUIBundle.plugins.DownloadUrl
                ],
                layout: "StandaloneLayout",
                persistAuthorization: true
            });
            window.ui = ui;
        };
    </script>
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
