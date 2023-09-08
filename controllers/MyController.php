<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\web\Response;
use Buyandsell\Tickets;
use Buyandsell\Rules\AuthorRule;

class MyController extends AccessController
{

    public function behaviors()
    {

        $rules = parent::behaviors();
        $rule = [
            'allow' => false,
            'actions' => ['remove', 'delete'],
            'matchCallback' => function ($rule, $action) {
                return Yii::$app->user->can('canUser');
            }
        ];

        $ruleModerator = [
            'allow' => true,
            'actions' => ['remove', 'delete'],
            'matchCallback' => function ($rule, $action) {
                return Yii::$app->user->can('viewContent', 'viewOwnContent');
            }
        ];

        array_unshift($rules['access']['rules'], $rule);
        array_unshift($rules['access']['rules'], $ruleModerator);

        return $rules;
    }

    public function actionIndex()
    {
        $model = new Tickets();

        $myTickets = $model->getMyTickets();

        return $this->render('index', [
            'model' => $model,
            'myTickets' => $myTickets
        ]);
    }

    public function actionDelete(int $id)
    {

        $model = new Tickets();
        $deleteTicket = $model->deleteMyTickets($id);
             
        return $this->refresh();
       
    }

    public function actionRemove(int $id)
    {

        $model = new Tickets();
        $deleteTicket = $model->removeComment($id);
             
        return $this->redirect('/my/comments');
       
    }

    public function actionComments()
    {

        $model = new Tickets();
        $myTicketsComments = $model->getMyTicketsComments();

        return $this->render('comments', [
            'myTicketsComments' => $myTicketsComments,
        ]);
    }
}
