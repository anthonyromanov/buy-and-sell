<?php

use yii\db\Migration;

/**
 * Class m230705_202224_insert_rows_to_ticket_table
 */
class m230705_202224_insert_rows_to_ticket_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('ticket', ['creation', 'title', 'picture', 'type', 'price', 'description', 'user_id'], [
            ['2023-07-05', 'Монстера', 'item01', 'buy', '1000', 'Куплю монстеру зеленую в хорошем зеленом состоянии, буду', '1'],
            ['2023-07-05', 'Мое старое кресло', 'item02', 'sell', '4000', 'Продам свое старое кресло, чтобы сидеть и читать книги зимними...', '1'],
            ['2023-07-05', 'Мое старое кресло', 'item02', 'sell', '4000', 'Продам свое старое кресло, чтобы сидеть и читать книги зимними...', '1'],
            ['2023-07-05', 'Дедушкины часы', 'item03', 'sell', '45000', 'Продаю дедушкины часы в прекрасном состоянии, ходят', '1'],
            ['2023-07-05', 'Кофеварка', 'item04', 'sell', '2000', 'Куплю вот такую итальянскую кофеварку, можно любой', '1'],
            ['2023-07-05', 'Ленд Ровер', 'item05', 'sell', '90000', 'Куплю монстеру зеленую в хорошем зеленом состоянии, буду', '1'],
            ['2023-07-05', 'Ленд Ровер', 'item05', 'sell', '90000', 'Куплю монстеру зеленую в хорошем зеленом состоянии, буду', '1'],
            ['2023-07-05', 'Ableton', 'item06', 'sell', '88000', 'Продам свое старое кресло, чтобы сидеть и читать книги зимними...', '1'],
            ['2023-07-05', 'Доска', 'item07', 'sell', '55000', 'Продаю дедушкины часы в прекрасном состоянии, ходят', '1'],
            ['2023-07-05', 'Фотик Canon', 'item08', 'buy', '32000', 'Куплю вот такую итальянскую кофеварку, можно любой', '1'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('ticket', ['creation', 'title', 'picture', 'type', 'price', 'description', 'user_id'], [
            ['2023-07-05', 'Монстера', 'item01', 'buy', '1000', 'Куплю монстеру зеленую в хорошем зеленом состоянии, буду', '1'],
            ['2023-07-05', 'Мое старое кресло', 'item01', 'sell', '4000', 'Продам свое старое кресло, чтобы сидеть и читать книги зимними...', '1'],
            ['2023-07-05', 'Мое старое кресло', 'item01', 'sell', '4000', 'Продам свое старое кресло, чтобы сидеть и читать книги зимними...', '1'],
            ['2023-07-05', 'Дедушкины часы', 'item02', 'sell', '45000', 'Продаю дедушкины часы в прекрасном состоянии, ходят', '1'],
            ['2023-07-05', 'Кофеварка', 'item03', 'sell', '2000', 'Куплю вот такую итальянскую кофеварку, можно любой', '1'],
            ['2023-07-05', 'Ленд Ровер', 'item04', 'sell', '90000', 'Куплю монстеру зеленую в хорошем зеленом состоянии, буду', '1'],
            ['2023-07-05', 'Ленд Ровер', 'item04', 'sell', '90000', 'Куплю монстеру зеленую в хорошем зеленом состоянии, буду', '1'],
            ['2023-07-05', 'Ableton', 'item05', 'sell', '88000', 'Продам свое старое кресло, чтобы сидеть и читать книги зимними...', '1'],
            ['2023-07-05', 'Доска', 'item06', 'sell', '55000', 'Продаю дедушкины часы в прекрасном состоянии, ходят', '1'],
            ['2023-07-05', 'Фотик Canon', 'item07', 'buy', '32000', 'Куплю вот такую итальянскую кофеварку, можно любой', '1'],
        ]);
    }
}
