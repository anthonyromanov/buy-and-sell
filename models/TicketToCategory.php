<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket_to_category".
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $category_id
 *
 * @property Category $category
 * @property Ticket $ticket
 */
class TicketToCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket_to_category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_id', 'category_id'], 'required'],
            [['ticket_id', 'category_id'], 'integer'],
            [['ticket_id'], 'exist', 'skipOnError' => true, 'targetClass' => Ticket::class,
            'targetAttribute' => ['ticket_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class,
            'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ticket_id' => 'Ticket ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Ticket]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTicket()
    {
        return $this->hasOne(Ticket::class, ['id' => 'ticket_id']);
    }
}
