<?php

namespace app\models;

use yii;
use yii\base\Model;
use app\models\User;
use app\models\Ticket;
use app\models\Comment;

class AddCommentForm extends Model
{
    public $ticket_id;
    public $user_id;
    public $comment;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ticket_id', 'user_id'], 'integer'],
            [['comment'], 'string'],
            [['comment'], 'required', 'message' => 'Обязательное поле'],
            [['ticket_id'], 'exist', 'skipOnError' => true,
            'targetClass' => Ticket::className(),
            'targetAttribute' => ['ticket_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true,
            'targetClass' => User::className(),
            'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'comment' => 'Текст комментария'
        ];
    }

    /**
     * Add Comment
     *
     */
    public function addComment($ticket_id)
    {
        $comment = new Comment();
        $comment->user_id = Yii::$app->user->getId();
        $comment->ticket_id = $ticket_id;
        $comment->comment = $this->comment;

        return $comment->save();
    }
}
