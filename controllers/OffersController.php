<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use app\models\Ticket;
use app\models\Category;
use Buyandsell\Tickets;
use app\models\AddCommentForm;
use app\models\AddTicketForm;
use app\models\EditTicketForm;
use yii\helpers\ArrayHelper;
use Buyandsell\Rules\AuthorRule;

class OffersController extends AccessController
{
    public function behaviors()
    {
        $rules = parent::behaviors();
        $ruleGuest = [
            'allow' => true,
            'actions' => ['edit', 'add'],
            'matchCallback' => function ($rule, $action) {
                return Yii::$app->user->can('canUser');
            }
        ];
        $rule = [
            'allow' => false,
            'actions' => ['edit', 'add'],
            'matchCallback' => function ($rule, $action) {
                return Yii::$app->user->can('viewContent');
            }
        ];

        array_unshift($rules['access']['rules'], $ruleGuest);
        array_unshift($rules['access']['rules'], $rule);

        return $rules;
    }

    public function actionIndex(int $id)
    {

        $ticket = Ticket::find()
        ->where(['ticket.id' => $id])
        ->joinWith(['user'])
        ->one();

        $model = new Tickets();
        $commentForm = new AddCommentForm();

        $comments = $model->getComments($id);

        $commentsCount = $model->getTicketCommentsCount($id);

        if (Yii::$app->request->getIsPost()) {
            $commentForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                 return ActiveForm::validate($commentForm);
            }
            if ($commentForm->validate()) {
                $commentForm->addComment($id);
                return $this->redirect(['offers/', 'id' => $id]);
            }
        }

        return $this->render('index', [
            'ticket' => $ticket,
            'comments' => $comments,
            'commentForm' => $commentForm,
            'commentsCount' =>  $commentsCount,
        ]);
    }

    public function actionAdd()
    {

        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'label');
        $types = ArrayHelper::map(Ticket::find()->all(), 'id', 'type');
        $ticketForm = new AddTicketForm();

        if (Yii::$app->request->getIsPost()) {
            $ticketForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }

            if ($ticketForm->validate()) {
                $ticketForm->addTicket();
                return $this->redirect(['my/']);
            }
        }

        return $this->render('add', [
            'ticketForm' => $ticketForm,
            'categories' => $categories,
            'types' => $types,
        ]);
    }

    public function actionEdit(int $id)
    {

        $ticket = Ticket::findOne($id);
        $ticketForm = new EditTicketForm();
        $categories = ArrayHelper::map(Category::find()->all(), 'id', 'label');

        if (Yii::$app->request->getIsPost()) {
            $ticketForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($ticketForm);
            }

            if ($ticketForm->validate()) {
                $ticketForm->editTicket($id);
                return $this->redirect(['offers/', 'id' => $ticket->id]);
            }
        }

        return $this->render('edit', [
            'ticket' => $ticket,
            'ticketForm' => $ticketForm,
            'categories' => $categories
        ]);
    }

    public function actionCategory($id)
    {

        $model = new Tickets();
        $categories = $model->getCategoriesList();
        $current_tickets = $model->getCurrentTickets($id);
        $tickets_count = $model->getCategoryTickets($id);
        $category_label = $model->getCategoryLabel($id);

        return $this->render('category', [
            'model' => $model,
            'categories' => $categories,
            'current_tickets' => $current_tickets,
            'tickets_count' => $tickets_count,
            'category_label' => $category_label,
        ]);
    }
}
