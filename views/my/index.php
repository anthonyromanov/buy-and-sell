<?php

use yii\helpers\Html;
use Buyandsell\Tickets;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>

<section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
      <div class="tickets-list__header">
        <a href="<?= Url::to(['/offers/add']); ?>" class="tickets-list__btn btn btn--big">
          <span>Новая публикация</span>
      </a>
      </div>
      <?php
        echo ListView::widget([
          'dataProvider' => $myTickets,
          'itemView' => 'myTicketsList',
          'itemOptions' => [
            'tag' => false,
          ],
          'layout' => '{items}',
          'emptyText' => false,
          'options' => [
            'tag' => 'ul',
          ],
        ]);
        ?>

    </div>
  </section>