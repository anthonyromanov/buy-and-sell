<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Ticket;
use Buyandsell\Tickets;
use \yii\helpers\StringHelper;
use yii\widgets\ListView;

?>
<?php if (Yii::$app->user->can('viewContent') && Tickets::getMyTicketsCommentsCount($model->id) > 0
|| Yii::$app->user->can('viewOwnContent', ['user_id' => Yii::$app->user->getId()]) && Tickets::getMyTicketsCommentsCount($model->id) > 0
) : ?>

<?php echo Yii::$app->user->can('viewOwnContent', ['user_id' => $model->id]); ?>
    <div class="comments__block">
        <div class="comments__header">
            <a href="<?= Url::to(['/offers', 'id' => $model->id]); ?>" class="announce-card">
                <h2 class="announce-card__title"><?= Html::encode($model->title);?></h2>
                <span class="announce-card__info">
                <span class="announce-card__price">₽ <?= Html::encode(Yii::$app->formatter->asDecimal($model->price)); ?></span>
                <span class="announce-card__type"><?= Tickets::getTicketType(Html::encode($model->type)); ?></span>
                </span>
            </a>
        </div>
        <ul class="comments-list">
            <?php foreach (Tickets::getMyTicketsCommentsData($model->id) as $data): ?>
                <li class="js-card">
                <div class="comment-card">
                    <div class="comment-card__header">
                        <a href="#" class="comment-card__avatar avatar">
                            <img src="<?= Html::encode($data->user->avatar);?>.jpg" srcset="<?= Html::encode($data->user->avatar);?>@2x.jpg 2x" alt="Аватар пользователя">
                        </a>
                        <p class="comment-card__author"><?= Html::encode($data->user->name);?></p>
                    </div>
                    <div class="comment-card__content">
                        <p><?= Html::encode($data->comment);?></p>
                    </div>

                        
                    <a href="<?= Url::to(['/my/remove', 'id' => $data->id]); ?>" class="comment-card__delete js-delete">Удалить</a>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>   
<?php endif; ?>
