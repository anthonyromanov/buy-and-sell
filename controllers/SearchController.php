<?php

namespace app\controllers;

use yii;
use yii\web\Controller;
use yii\web\Response;
use app\models\Ticket;
use yii\bootstrap5\ActiveForm;
use yii\helpers\ArrayHelper;
use Buyandsell\Tickets;

class SearchController extends Controller
{
    /**
     * Search action.
     *
     * @return Response
     */
    public function actionIndex()
    {
        if (Yii::$app->request->getIsget()) {
            $query = trim(Yii::$app->request->get(name: 'query'));
        }

        $model = new Tickets();
        $results = Ticket::find()->where(['like', 'title', $query])->all();
        $count = Ticket::find()->where(['like', 'title', $query])->count();
        $freshTickets = $model->getFreshTickets();

        return $this->render('index', [
               'results' => $results,
               'count' => $count,
               'freshTickets' => $freshTickets,
            ]);
    }
}
