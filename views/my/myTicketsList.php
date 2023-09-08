<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Ticket;
use Buyandsell\Tickets;
use yii\helpers\StringHelper;

?>
<li class="tickets-list__item js-card">
    <div class="ticket-card ticket-card--color<?php echo sprintf("%02d", Html::encode(Tickets::getCardColor($model->id)));?>">
        <div class="ticket-card__img">
            <img src="<?= Html::encode($model->picture);?>.jpg" srcset="<?= Html::encode($model->picture);?>@2x.jpg 2x" alt="Изображение <?= Html::encode($model->title);?>">
        </div>
        <div class="ticket-card__info">
            <span class="ticket-card__label"><?= Tickets::getTicketType(Html::encode($model->type)); ?></span>
            <div class="ticket-card__categories">
            <?php foreach (Tickets::getCategoriesToTicket($model->id) as $category) : ?>
                <a href="<?= Html::encode($category->id); ?>"><?= Html::encode($category->label); ?></a>
            <?php endforeach; ?>
            </div>
            <div class="ticket-card__header">
                <h3 class="ticket-card__title">
                    <?php if (Yii::$app->user->can('viewOwnContent', ['user_id' => Yii::$app->user->getId()])) : ?>
                    <a href="<?= Url::to(['/offers/edit', 'id' => $model->id]); ?>"><?= Html::encode($model->title);?></a>
                    <?php endif; ?>
                    <?php if (Yii::$app->user->can('viewContent')) : ?>
                        <?= Html::encode($model->title);?>
                    <?php endif; ?>
                </h3>
                <p class="ticket-card__price"><span class="js-sum"><?= Html::encode(Yii::$app->formatter->asDecimal($model->price)); ?></span> ₽</p>
            </div>
        </div>
        <a href="<?= Url::to(['/my/delete', 'id' => $model->id]); ?>" class="ticket-card__del js-delete">Удалить</a>
    </div>
</li>
