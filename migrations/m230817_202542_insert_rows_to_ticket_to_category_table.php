<?php

use yii\db\Migration;

/**
 * Class m230817_202542_insert_rows_to_ticket_to_category_table
 */
class m230817_202542_insert_rows_to_ticket_to_category_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('ticket_to_category', ['ticket_id', 'category_id'], [
            [1, 1],
            [2, 1],
            [3, 2],
            [3, 1],
            [4, 1],
            [5, 5],
            [5, 2],
            [6, 2],
            [7, 4],
            [8, 2],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('ticket_to_category', ['ticket_id', 'category_id'], [
            [1, 1],
            [2, 1],
            [3, 2],
            [3, 1],
            [4, 1],
            [5, 5],
            [5, 2],
            [6, 2],
            [7, 4],
            [8, 2],
        ]);
    }
}
