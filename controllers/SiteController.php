<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Category;
use app\models\Ticket;
use Buyandsell\Tickets;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use app\models\User;
use app\models\Auth;
use yii\authclient\clients\VKontakte;
use Buyandsell\VK;

class SiteController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
              'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Tickets();

        $categories = $model->getCategoriesList();
        $fresh_tickets = $model->getFreshTickets();
        $popular_tickets = $model->getPopularTickets();

        return $this->render('index', [
            'categories' => $categories,
            'fresh_tickets' => $fresh_tickets,
            'popular_tickets' => $popular_tickets,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        return $this->goHome();
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Auth action.
     *
     * @return string
     */
    public function onAuthSuccess($client)
    {
        $attributes = $client->getUserAttributes();

        $vk = new Vk();
        $auth = $vk->auth($client, $attributes);

        if (Yii::$app->user->isGuest) {
            if ($auth) {
                $user = $auth->user;
                Yii::$app->user->login($user);
                $this->goHome();
            }

            if (isset($attributes['email']) && User::find()->where(['email' => $attributes['email']])->exists()) {
                Yii::$app->getSession()->setFlash('error', [
                    Yii::t('app', "Пользователь с такой электронной почтой как в {client} уже существует,
                    но с ним не связан. Для начала войдите на сайт использую электронную почту для того,
                    чтобы связать её.", ['client' => $client->getTitle()]),
                ]);
            }

            $auth = $vk->registration($client, $attributes);
            $this->goHome();
        }

        else { // Пользователь уже зарегистрирован
            if (!$auth) { // добавляем внешний сервис аутентификации
                $auth = new Auth([
                    'user_id' => Yii::$app->user->id,
                    'source' => $client->getId(),
                    'source_id' => $attributes['id'],
                ]);
                $auth->save();
            }
        }
    }   
}
