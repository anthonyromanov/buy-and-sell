<?php

use yii\db\Migration;

/**
 * Class m230705_192851_insert_rows_to_category_table
 */
class m230705_192851_insert_rows_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('category', ['path', 'label'], [
            ['cat01', 'Дом'],
            ['cat02', 'Электроника'],
            ['cat03', 'Одежда'],
            ['cat04', 'Спорт/отдых'],
            ['cat05', 'Авто'],
            ['cat06', 'Книги'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('category', ['path', 'label'], [
            ['cat01', 'Дом'],
            ['cat02', 'Электроника'],
            ['cat03', 'Одежда'],
            ['cat04', 'Спорт/отдых'],
            ['cat05', 'Авто'],
            ['cat06', 'Книги'],
        ]);
    }
}
