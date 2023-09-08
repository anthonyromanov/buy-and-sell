<?php
namespace app\models\forms;

use yii\base\Model;

class ChatForm extends Model
{
    public string $message = '';

    public function rules(): array
    {
        return [
            [['message'], 'string'],
        ];
    }

    public function attributeLabels(): array
    {
        return [
            'message' => 'Ваше сообщение в чат',
        ];
    }

    public function getMessage()
    {
        return $this->message;
    }
}