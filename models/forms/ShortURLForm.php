<?php

namespace app\models\forms;

use yii\base\Model;
use yii\httpclient\Client;


class ShortURLForm extends Model
{
    public $url;


    public function rules()
    {
        return [
            [['url'], 'required', 'message' => 'URL не должен быть пустым!'],
            [['url'], 'url', 'message' => 'Неверный URL!'],
            [['url'], 'isUrlAvailable'],
        ];
    }


    public function attributeLabels()
    {
        return [
            'url' => 'URL-адрес',
        ];
    }

    public function isUrlAvailable($attribute, $params)
    {
        try {
            $client = new Client();
            $response = $client->createRequest()
                ->setMethod('GET')
                ->setUrl($this->$attribute)
                ->setOptions([
                    'timeout' => 5,
                    'followRedirects' => true,
                ])
                ->send();
            if (!$response->getIsOk()) $this->addError($attribute, 'URL недоступен!');
        } catch (\Exception $e) {
            $this->addError($attribute, 'URL недоступен!');
        }
    }

}
