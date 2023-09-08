<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $registration
 * @property string $name
 * @property string|null $birthday
 * @property string|null $avatar
 * @property string $email
 * @property string|null $vk_token
 * @property string $password
 *
 * @property Comment[] $comments
 * @property Ticket[] $tickets
 */
class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    public $repeat_password;

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }

    /**
     * {@inheritdoc}
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['registration', 'birthday'], 'safe'],
            [['name', 'email', 'password'], 'required'],
            [['vk_token'], 'integer'],
            [['name', 'email'], 'string', 'max' => 128],
            [['avatar', 'password'], 'string', 'max' => 255],
            [['email'], 'unique', 'message' => 'введите адрес'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'registration' => 'Registration',
            'name' => 'Имя',
            'birthday' => 'Birthday',
            'avatar' => 'Аватар',
            'email' => 'Электронная почта',
            'vk_token' => 'Vk Token',
            'password' => 'Пароль',
        ];
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Tickets]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTickets()
    {
        return $this->hasMany(Ticket::class, ['user_id' => 'id']);
    }
}
