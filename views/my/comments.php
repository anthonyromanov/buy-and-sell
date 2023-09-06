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
      <?php $commentsCount = Tickets::getCommentsCount(); ?>
      <?php if (!isset($commentsCount) || $commentsCount === 0) : ?> 
      <p class="comments__message">У ваших публикаций еще нет комментариев.</p>
      <?php endif; ?>

      <?php if (isset($commentsCount) && $commentsCount !== 0) : ?> 
      <?php
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
      ?>
      <?php endif; ?>
    </div>
  </section>