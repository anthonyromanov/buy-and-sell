<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\ListView;
use yii\widgets\LinkPager;

$this->title = 'Куплю Продам';

$this->registerCssFile(
    '/css/custom.css'
);

?>

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
  <section class="tickets-list">
    <h2 class="visually-hidden">Предложения из категории <?= Html::encode($category_label);?></h2>
    <div class="tickets-list__wrapper">
      <div class="tickets-list__header">
        <p class="tickets-list__title"><?= Html::encode($category_label);?> <b class="js-qty">
          <?= Html::encode($tickets_count);?></b></p>
      </div>
            <?php echo ListView::widget([
                  'dataProvider' => $current_tickets,
                  'itemView' => 'currentTicketsList',
                  'itemOptions' => [
                    'tag' => false,
                  ],
                  'layout' => '<ul>{items}</ul><div class="tickets-list__pagination">{pager}</div>',
                  'summary' => '',
                  'pager' => [
                      'prevPageLabel' => '',
                      'nextPageLabel' => 'далее',
                      'disableCurrentPageButton' => true,
                      'options' => [
                          'tag' => 'ul',
                          'class' => 'pagination'
                      ],
                      'linkContainerOptions' => ['class' => 'pagination-item'],
                      'linkOptions' => ['class' => 'pagination-link'],
                   ],
              ]);
            ?>
    </div>
  </section>