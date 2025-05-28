<?php

namespace app\services;

use app\models\forms\ShortURLForm;
use app\models\RedirectLogs;
use app\models\ShortLinks;
use Yii;
use yii\web\ServerErrorHttpException;

class ShortUrlService
{

    function generateShortLink(int $length = 10): string {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ-_';
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= $chars[random_int(0, 61)];
        }
        return $result;
    }

    public function createShortLink(ShortURLForm $form): array
    {
        $shortLink = $this->generateShortLink();
        $model = new ShortLinks();

        $model->short_link = $shortLink;
        $model->original_link = $form->url;


        if (!$model->save()) return ['status' => 'error', 'message' => 'Не удалось создать короткую ссылку!'];


        return ['status' => 'success', 'model' => $model];
    }

    public function redirectShortLink(string $shortUrl): ShortLinks
    {
        $model = ShortLinks::findOne(['short_link' => $shortUrl]);
        $model->redirect_qty += 1;
        if (!$model->save()) throw new ServerErrorHttpException('Не удалось обновить информацию по ссылке');


        $redirectLogModel = new RedirectLogs();
        $redirectLogModel->short_link_id = $model->id;
        $redirectLogModel->ip = Yii::$app->request->userIP;
        if(!$redirectLogModel->save()) throw new ServerErrorHttpException('Не удалось обновить информацию по посещению');

        return $model;
    }
}