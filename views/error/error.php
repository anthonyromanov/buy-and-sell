<?php

/* @var $this yii\web\View */
/* @var $exception; === стек */
/* @var $statusCode; === код ошибки  */
/* @var $name; === имя ошибки  */
/* @var $message; === текс ошибка */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->title = $message;
$this->context->layout = 'error';

?>

<section class="error">

      <h1 class="error__title"><?= nl2br(Html::encode($statusCode)) ?></h1>
      <h2 class="error__subtitle"><?= nl2br(Html::encode($message)) ?></h2>
      <ul class="error__list">
        <?php if (Yii::$app->user->isGuest) : ?>
        <li class="error__item">
          <a href="<?= Url::to(['/login']); ?>">Вход и регистрация</a>
        </li>
        <?php endif; ?>
        <?php if (!Yii::$app->user->isGuest) : ?>
        <li class="error__item">
          <a href="<?= Url::to(['/offers/add']); ?>">Новая публикация</a>
        </li>
        <?php endif; ?>
        <li class="error__item">
          <a href="<?= Url::home(); ?>">Главная страница</a>
        </li>
      </ul>
      <form class="error__search search search--small" method="get" action="<?= Url::to(['/search']); ?>"
      autocomplete="off">
        <input type="search" name="query" placeholder="Поиск" aria-label="Поиск" 
        value ="<?php (Yii::$app->request->getIsget()) ??
        Html::encode(trim(Yii::$app->request->get(name: 'query'))) ?>">
        <div class="search__icon"></div>
        <div class="search__close-btn"></div>
      </form>

      <a class="error__logo logo" href="main.html">
        <img src="/img/logo.svg" width="179" height="34" alt="Логотип Куплю Продам">
      </a>
    </section>