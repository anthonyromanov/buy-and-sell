<?php

use yii\db\Migration;

/**
 * Class m230705_205428_insert_rows_to_user_table
 */
class m230705_205428_insert_rows_to_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('user', ['registration', 'name', 'birthday', 'avatar', 'email', 'vk_token', 'password'], [
            ['2023-07-05', 'Anton', '1981-01-19', 'avatar01', 'info@antonromanov.ru', 'token', 'qwerty1'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('user', ['registration', 'name', 'birthday', 'avatar', 'email', 'vk_token', 'password'], [
            ['2023-07-05', 'Anton', '1981-01-19', 'avatar01', 'info@antonromanov.ru', 'token', 'qwerty1'],
        ]);
    }
}
