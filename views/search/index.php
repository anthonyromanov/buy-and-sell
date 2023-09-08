<?php

use yii\helpers\Html;
use Buyandsell\Tickets;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\StringHelper;

?>

<section class="search-results">
    <h1 class="visually-hidden">Результаты поиска</h1>
    <div class="search-results__wrapper">
    <?php if (isset($count) && $count !== 0) : ?> 
      <p class="search-results__label">Найдено <span class="js-results"><?= Html::encode($count); ?> публикации</span></p>
      <ul class="search-results__list">
        <?php foreach ($results as $search) : ?>
        <li class="search-results__item">
          <div class="ticket-card ticket-card--color<?php echo sprintf("%02d", Html::encode($search->id));?>">
            <div class="ticket-card__img">
              <img src="<?= Html::encode($search->picture); ?>.jpg" srcset="<?= Html::encode($search->picture); ?>@2x.jpg 2x" alt="Изображение товара">
            </div>
            <div class="ticket-card__info">
              <span class="ticket-card__label"><?= Tickets::getTicketType(Html::encode($search->type)); ?></span>
              <div class="ticket-card__categories">
                <a href="#"><?= Html::encode(Tickets::getTicketCategories($search->id)); ?></a>
              </div>
              <div class="ticket-card__header">
                <h3 class="ticket-card__title"><a href="#"><?= Html::encode($search->title); ?></a></h3>
                <p class="ticket-card__price"><span class="js-sum"><?= Html::encode(Yii::$app->formatter->asDecimal($search->price)); ?></span> ₽</p>
              </div>
              <div class="ticket-card__desc">
                <p><?= Html::encode(StringHelper::truncate($search->description, 55, '...')); ?></p>
              </div>
            </div>
          </div>
        </li>
        <?php endforeach; ?>        
      </ul>
    <?php endif; ?>

    <?php if (!isset($count) || $count === 0) : ?> 
        <div class="search-results__message">
          <p>Не найдено <br>ни&nbsp;одной публикации</p>
        </div>  
    <?php endif; ?>  
    </div>
  </section>

  <section class="tickets-list">
    <h2 class="visually-hidden">Самые новые предложения</h2>
    <div class="tickets-list__wrapper">
      <?php
        echo ListView::widget([
                  'dataProvider' => $freshTickets,
                  'itemView' => '/site/ticketsList',
                  'itemOptions' => [
                    'tag' => false,
                  ],
                  'layout' =>  '<div class="tickets-list__header"><p class="tickets-list__title">Самое свежее</p><a href="#" class="tickets-list__link"><div>{pager}</div></a></div><ul>{items}</ul>',
                  'summary' => 'Ещё {count}',
                  'emptyText' => false,
                  'options' => [
                    'tag' => false,
                  ],
                  'pager' => [
                    'prevPageLabel' => '',
                    'nextPageLabel' => 'Еще',
                    'maxButtonCount' => 0,
                    'options' => [
                        'tag' => 'ul',
                        'class' => 'pagination',
                    ],
                    'linkOptions' => [
                      'tag' => 'ul',
                      'class' => 'tickets-list__link'
                    ],
                  ],
              ]);
        ?> 
    </div>
  </section>