<?php

use yii\db\Migration;

class m170111_131347_user extends Migration
{
    public function up()
    {
        $this->createTable('user',
            [
                'id'       => $this->primaryKey(11),
                'name'     => $this->string(50)->defaultValue(''),
                'email'    => $this->string(50),
                'auth_key' => $this->string(32),
            ]
        );

        $this->createIndex('idx_email', '{{%user}}', 'email', true);
        $this->createIndex('idx_auth_key', '{{%user}}', 'auth_key', true);
    }

    public function down()
    {
        $this->dropTable('user');
    }
}
