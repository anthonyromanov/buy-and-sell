<?php

namespace Buyandsell;

use Yii;
use app\models\User;
use app\models\Auth;
use yii\authclient\clients\VKontakte;

class VK
{
    /**
     * Add authorization
     *
     */

    public function auth($client, $attributes)
    {
        /* @var $auth Auth */
        $auth = Auth::find()->where([
        'source' => $client->getId(),
        'source_id' => $attributes['id'],
        ])->one();

        return $auth;
    }

    /**
     * Add Registration
     *
     */
    public function registration($client, $attributes)
    {
        $password = Yii::$app->security->generateRandomString(6);
        $user = new User();
        if (isset($attributes['first_name'], $attributes['last_name'])) {
            $user->name = implode(' ', array($attributes['first_name'], $attributes['last_name']));
        }
        if (isset($attributes['email'])) {
            $user->email = $attributes['email'];
        } else {
            $user->name = 'Аноним';
            $user->email = $attributes['id'] . '@buyandsell.com';
        }
        $user->password = Yii::$app->security->generatePasswordHash($password);
        $user->avatar = $attributes['photo'];
        $user->vk_token = $attributes['id'];
        $birthdayDate = \DateTime::createFromFormat('d.m.Y', $attributes['bdate']);
        $user->birthday = $birthdayDate ? $birthdayDate->format('Y-m-d') : '2000-01-01';
        if ($user->save()) {
            $auth = new Auth([
                'user_id' => $user->id,
                'source' => $client->getId(),
                'source_id' => $attributes['id'],
            ]);

            //Даем роль Пользователя
            $userRole = Yii::$app->authManager->getRole('user');
            Yii::$app->authManager->assign($userRole, $user->getId());
            
            if ($auth->save()) {
                Yii::$app->user->login($user);
            }
        }
    }
}
