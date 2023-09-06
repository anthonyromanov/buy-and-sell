<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Ticket;
use Buyandsell\Tickets;
use \yii\helpers\StringHelper;

?>
        <li class="tickets-list__item">
          <div class="ticket-card ticket-card--color<?php echo sprintf("%02d", Html::encode($model->ticket->id));?>">
            <div class="ticket-card__img">
              <img src="<?= Html::encode($model->ticket->picture); ?>.jpg" srcset="<?= Html::encode($model->ticket->picture); ?>@2x.jpg 2x" alt="Изображение товара">
            </div>
            <div class="ticket-card__info">
              <span class="ticket-card__label"><?= Tickets::getTicketType(Html::encode($model->ticket->type)); ?></span>
              <div class="ticket-card__categories">
              <?php foreach (Tickets::getCategoriesToTicket($model->ticket->id) as $category): ?>
                <a href="<?= Html::encode($category->id); ?>"><?= Html::encode($category->label); ?></a>
            <?php endforeach; ?>
              </div>
              <div class="ticket-card__header">
                <h3 class="ticket-card__title"><a href="<?= Url::to(['/offers', 'id' => $model->ticket->id]); ?>"><?= Html::encode($model->ticket->title); ?></a></h3>
                <p class="ticket-card__price"><span class="js-sum"><?= Html::encode(Yii::$app->formatter->asDecimal($model->ticket->price)); ?></span> ₽</p>
              </div>
              <div class="ticket-card__desc">
                <p><?= Html::encode(StringHelper::truncate($model->ticket->description, 55,'...')); ?></p>
              </div>
            </div>
          </div>
        </li>
