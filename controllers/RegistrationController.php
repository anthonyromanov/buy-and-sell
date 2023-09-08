<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\RegistrationForm;
use yii\web\Response;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;

class RegistrationController extends AccessController
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

        $form = new RegistrationForm();

        if (Yii::$app->request->getIsPost()) {
            $form->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }
            if ($form->validate()) {
                $form->registration();
                return $this->redirect(['/login']);
            }
        }

        return $this->render('index', [
            'model' => $form,
        ]);
    }
}
