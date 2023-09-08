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
        $rule = [
            'allow' => false,
            'actions' => ['edit', 'add'],
            'matchCallback' => function ($rule, $action) {
                return Yii::$app->user->can('viewContent');
            }
        ];

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
            if ( $commentForm->validate()) {
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

        if (Yii::$app->request->getIsPost())
        {
            $ticketForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($form);
            }
            
            if ($ticketForm->validate())
            {
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

        if (Yii::$app->request->getIsPost())
        {
            $ticketForm->load(Yii::$app->request->post());
            if (Yii::$app->request->isAjax)
            {
                Yii::$app->response->format = Response::FORMAT_JSON;
                    return ActiveForm::validate($ticketForm);
            }
            
            if ($ticketForm->validate())
            {
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

    public function actionRole()
    {

    /*
        $admin = Yii::$app->authManager->createRole('admin');
        $admin->description = 'Администратор';
        Yii::$app->authManager->add($admin);
         
        $moderator = Yii::$app->authManager->createRole('moderator');
        $moderator->description = 'Модератор';
        Yii::$app->authManager->add($moderator);
         
        $user = Yii::$app->authManager->createRole('user');
        $user->description = 'Пользователь';
        Yii::$app->authManager->add($user);
    
        $permit = Yii::$app->authManager->createPermission('canUser');
        $permit->description = 'Право входа в личный кабинет';
        Yii::$app->authManager->add($permit);
    
        $adminRole = Yii::$app->authManager->getRole('admin');
        $userRole = Yii::$app->authManager->getRole('user');
        $moderatorRole = Yii::$app->authManager->getRole('moderator');
        $permit = Yii::$app->authManager->getPermission('canUser');
        Yii::$app->authManager->addChild($adminRole, $permit);
        Yii::$app->authManager->addChild($userRole, $permit);
        Yii::$app->authManager->addChild($moderatorRole, $permit);


        $userRole = Yii::$app->authManager->getRole('user');
        Yii::$app->authManager->assign($userRole, Yii::$app->user->getId());

    
        // Добавляем правило проверки является ли текущий пользователь автором объявления
        $auth = Yii::$app->authManager;
        $rule = new AuthorRule();
        $auth->add($rule);

        // Добавляем разрешение "canModerator"
        $canModerator = Yii::$app->authManager->createPermission('canModerator');
        $canModerator->description = 'Редактирование объявления';
        Yii::$app->authManager->add($canModerator);
  
        // Добавляем разрешение "canAuthor"
        $canAuthor = Yii::$app->authManager->createPermission('canAuthor');
        $canAuthor->description = 'Смотреть свои объявления и комментарии';
        $canAuthor->ruleName = $rule->name;
        Yii::$app->authManager->add($сanAuthor);

        // Добавляем наследование 
        //$userRole = Yii::$app->authManager->getRole('user');
        //$moderatorRole = Yii::$app->authManager->getRole('moderator');
        //Yii::$app->authManager->addChild($userRole, $canAuthor);
        //Yii::$app->authManager->addChild($moderatorRole, $canModerator);

   */     
        return 'Добавлено';
    }

}
