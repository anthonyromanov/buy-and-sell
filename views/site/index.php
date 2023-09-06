<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\helpers\Url;

$this->title = 'Куплю Продам';

?>

<h1 class="visually-hidden">Сервис объявлений "Куплю - продам"</h1> 
  <?php if (!empty($fresh_tickets)) : ?>
  <section class="categories-list">
    <?php
      echo ListView::widget([
        'dataProvider' => $categories,
        'itemView' => 'categoriesList',
        'itemOptions' => [
        'tag' => false,
        ],
        'layout' => '{items}',
        'emptyText' => false,
        'options' => [
        'tag' => 'ul',
        'class' => 'categories-list__wrapper',
        ],
      ]);
    ?>
  </section>
  <section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
      <div class="tickets-list__header"><p class="tickets-list__title">Самое свежее</p></div>
      <?php
        echo ListView::widget([
                  'dataProvider' => $fresh_tickets,
                  'itemView' => 'ticketsList',
                  'itemOptions' => [
                    'tag' => false,
                  ],
                  'layout' =>  '{items}',
                  'emptyText' => false,
                  'options' => [
                    'tag' => 'ul',
                  ],
              ]);
      ?>
    </div>
  </section>
  <?php if (!empty($popular_tickets)) : ?>
  <section class="tickets-list">
    <h2 class="visually-hidden">Самые обсуждаемые предложения</h2>
    <div class="tickets-list__wrapper">
      <div class="tickets-list__header">
        <p class="tickets-list__title">Самые обсуждаемые</p>
      </div>
      <?php
        echo ListView::widget([
                  'dataProvider' => $popular_tickets,
                  'itemView' => 'popularTicketsList',
                  'itemOptions' => [
                    'tag' => false,
                  ],
                  'layout' =>  '{items}',
                  'emptyText' => false,
                  'options' => [
                    'tag' => 'ul',
                  ],
              ]);
      ?>
    </div>
  </section>
  <?php endif; ?>
  <?php else: ?>
    <div class="message">
    <div class="message__text">
      <p>На сайте еще не опубликовано ни&nbsp;одного объявления.</p>
    </div>
    <a href="<?= Url::to(['/login']); ?>" class="message__link btn btn--big">Вход и регистрация</a>
  </div>
  <?php endif; ?>
