<?php
namespace app\models;

use yii\db\ActiveRecord;

class RedirectLogs extends ActiveRecord
{
    public static function tableName()
    {
        return '{{redirect_logs}}';
    }

    public function rules()
    {
        return [
            [['id', 'short_link_id'], 'integer'],
            [['ip'], 'ip', 'ipv6' => false],
            [['created_at'], 'safe'],
        ];
    }


}