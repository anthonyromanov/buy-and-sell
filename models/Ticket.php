<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property string $creation
 * @property string $title
 * @property string|null $picture
 * @property string|null $type
 * @property int $price
 * @property string|null $description
 * @property int $user_id
 *
 * @property Category $category
 * @property Comment[] $comments
 * @property User $user
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['creation'], 'safe'],
            [['title', 'price', 'user_id'], 'required'],
            [['type'], 'string'],
            [['price', 'user_id'], 'integer'],
            [['title', 'picture'], 'string', 'max' => 255],
            [['description'], 'string'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class,
            'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'creation' => 'Creation',
            'title' => 'Title',
            'picture' => 'Picture',
            'type' => 'Type',
            'price' => 'Price',
            'description' => 'Description',
            'user_id' => 'User ID',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['ticket_id' => 'id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[TicketToCategory]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::class, ['id' => 'category_id'])
        ->viaTable('ticket_to_category', ['ticket_id' => 'id']);
    }
}
