<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use yii\web\Controller;
use yii\web\Response;

class LoginController extends AccessController
{

    public function behaviors()
    {
        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['index'],
            'matchCallback' => function ($rule, $action) {
                return Yii::$app->user->can('canUser');
            }
        ];

        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionIndex()
    {

        $model = new LoginForm();
        if (Yii::$app->request->getIsPost()) {
            $model->load(Yii::$app->request->post());
            if ($model->validate()) {
                $user = $model->getUser();
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}
