<?php

use yii\db\Migration;

/**
 * Class m230820_182620_insert_rows_to_comment_table
 */
class m230820_182620_insert_rows_to_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('comment', ['ticket_id', 'user_id', 'comment'], [
            [1, 1, 'Отличная монстера'],
            [2, 1, 'Прикольное кресло'],
            [2, 1, 'Кресло в хорошем состоянии'],
            [5, 1, 'Надежное авто'],
            [5, 1, 'Машина в хорошем состоянии'],
            [5, 1, 'Дороговато для авто с пробегом'],
            [5, 1, 'На авто.ру можно найти машину и поновее за такие деньги, хотя тачка в хорошем состоянии'],
            [6, 1, 'Хороший агрегат'],
            [6, 1, 'Дороговато'],
            [6, 1, 'Прикольная электроника'],
            [8, 1, 'Фотик моей мечты'],
            [8, 1, 'Классные линзы'],
            [8, 1, 'Отличный объектив'],
            [8, 1, 'Фотоаппарат в хорошем состоянии'],
            [8, 1, 'Отличный помощник для начинающего'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->delete('comment', ['ticket_id', 'user_id', 'comment'], [
            [1, 1, 'Отличная монстера'],
            [2, 1, 'Прикольное кресло'],
            [2, 1, 'Кресло в хорошем состоянии'],
            [5, 1, 'Надежное авто'],
            [5, 1, 'Машина в хорошем состоянии'],
            [5, 1, 'Дороговато для авто с пробегом'],
            [5, 1, 'На авто.ру можно найти машину и поновее за такие деньги, хотя тачка в хорошем состоянии'],
            [6, 1, 'Хороший агрегат'],
            [6, 1, 'Дороговато'],
            [6, 1, 'Прикольная электроника'],
            [8, 1, 'Фотик моей мечты'],
            [8, 1, 'Классные линзы'],
            [8, 1, 'Отличный объектив'],
            [8, 1, 'Фотоаппарат в хорошем состоянии'],
            [8, 1, 'Отличный помощник для начинающего'],
        ]);
    }
}
