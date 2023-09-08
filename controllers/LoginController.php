<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use yii\web\Controller;
use yii\web\Response;
use yii\bootstrap5\ActiveForm;

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
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if ($model->validate()) {
                $user = $model->getUser();
                Yii::$app->user->login($user);
                return $this->goHome();
            }
        }

        return $this->render('index', ['model' => $model]);
    }
}
