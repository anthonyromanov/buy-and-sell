<?php

use yii\helpers\Html;
use Buyandsell\Tickets;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<section class="comments">
    <div class="comments__wrapper">
      <h1 class="visually-hidden">Страница комментариев</h1>
      <?php $commentsCount = Tickets::getCommentsCount();
        if (
            Yii::$app->user->can('viewOwnContent', ['user_id' => Yii::$app->user->getId()])
            && $commentsCount === 0
        ) : ?>
      <p class="comments__message">У ваших публикаций еще нет комментариев.</p>
        <?php endif; ?>

      <?php
        if (
            Yii::$app->user->can('viewOwnContent', ['user_id' => Yii::$app->user->getId()])
            && $commentsCount !== 0
            || Yii::$app->user->can('viewContent')
        ) {
            echo ListView::widget([
            'dataProvider' => $myTicketsComments,
            'itemView' => 'announceCard',
            'itemOptions' => [
            'tag' => false,
            ],
            'layout' => '{items}',
            'emptyText' => false,
            'options' => [
            'tag' => false,
            ],
            ]);
        }
        ?>

    </div>
  </section>