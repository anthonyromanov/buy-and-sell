<?php

namespace app\models;

use yii;
use yii\base\Model;
use app\models\User;
use yii\web\UploadedFile;
use Taskforce\Exceptions\NoEditSettingsException;

class RegistrationForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $repeat_password;
    
    /**
     * @var UploadedFile
     */
    public $avatar;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'repeat_password'], 'required'],
            [['name'], 'match', 'pattern' => '~^(\p{L}|\p{Zs})+$~u'],
            [['password', 'repeat_password', 'name', 'email'], 'string', 'min' => 6],
            [['password', 'repeat_password'], 'string', 'min' => 6],
            [['repeat_password'], 'compare', 'compareAttribute' => 'password'],
            [['email'], 'email', 'message' => 'Неверный email'],
            [['email'], 'unique', 'targetClass' => User::class],
            [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Имя и фамилия',
            'email' => 'Эл. почта',
            'password' => 'Пароль',
            'repeat_password' => 'Пароль еще раз',
            'avatar' => 'Загрузите фото',
        ];
    }

    /**
     * Upload photo before validation
     *
     */

    public function beforeValidate()
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');
        return parent::beforeValidate();
    }

    /**
     * Registration
     *
     */
    public function registration()
    {
        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->password = Yii::$app->security->generatePasswordHash($this->password);

        $this->avatar = UploadedFile::getInstance($this, 'avatar');
        
        if ($this->avatar) {
            $newname = uniqid('avatar') . '.' . $this->avatar->getExtension();
            $this->avatar->saveAs('@webroot/uploads/avatars/' . $newname);
            $user->avatar = '/' . 'uploads/avatars/' . uniqid('avatar');
        }

        $user->save();

        //Даем роль Пользователя
        $auth = Yii::$app->authManager;
        $userRole = $auth->getRole('user');
        $auth->assign($userRole, $user->getId());

        return $user;



    }
}
