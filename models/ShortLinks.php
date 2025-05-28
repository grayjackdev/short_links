<?php
namespace app\models;

use yii\db\ActiveRecord;


class ShortLinks extends ActiveRecord
{
    public static function tableName()
    {
        return 'short_links';
    }

    public function rules()
    {
        return [
            [['id', 'redirect_qty'], 'integer'],
            [['original_link'], 'url'],
            [['created_at', 'short_link'], 'safe'],
        ];
    }


}