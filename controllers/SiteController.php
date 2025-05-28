<?php

namespace app\controllers;

use app\models\forms\ShortURLForm;
use app\services\ShortUrlService;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Yii;
use yii\bootstrap5\ActiveForm;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\Response;


class SiteController extends Controller
{

    private ShortUrlService $shortUrlService;

    public function __construct($id,
                                $module,
                                ShortUrlService $shortUrlService,
                                $config = [])
    {
        $this->shortUrlService = $shortUrlService;
        parent::__construct($id, $module, $config);
    }


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['get', 'post'],
                ],
            ],
        ];
    }


    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new ShortURLForm();
        return $this->render('index', ['model' => $model]);
    }

    public function actionGenerateUrl()
    {
        $model = new ShortURLForm();

        if (!Yii::$app->request->isAjax) return $this->redirect(['site/index']);
        Yii::$app->response->format = Response::FORMAT_JSON;


            if ($model->load(Yii::$app->request->post()) && $model->validate())
            {
                $result = $this->shortUrlService->createShortLink($model);

                if ($result['status'] === 'success')
                {
                    $templatePart = $this->renderPartial('includes/_short_link_info', ['model' => $result['model']]);
                    return ['status' => 'success', 'html' => $templatePart];
                } else return $result;

            } return ['status' => 'validation_error', 'validation_errors' => ActiveForm::validate($model)];

    }

    public function actionRedirectUrl($short_url) {
        $model = $this->shortUrlService->redirectShortLink($short_url);
        return $this->redirect($model->original_link);
    }

}
