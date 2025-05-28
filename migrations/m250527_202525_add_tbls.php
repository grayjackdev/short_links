<?php

use yii\db\Migration;

class m250527_202525_add_tbls extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('short_links', [
            'id' => $this->primaryKey(),
            'short_link' => $this->string(128),
            'original_link' => $this->string(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()'),
            'redirect_qty' => $this->integer()
        ]);

        $this->createTable('redirect_logs', [
            'id' => $this->primaryKey(),
            'short_link_id' => $this->string(128),
            'ip' => $this->string(),
            'created_at' => $this->dateTime()->defaultExpression('NOW()')
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m250527_202525_add_tbls cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m250527_202525_add_tbls cannot be reverted.\n";

        return false;
    }
    */
}
