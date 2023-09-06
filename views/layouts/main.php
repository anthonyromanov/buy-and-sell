<?php

/** @var yii\web\View $this */
/** @var string $content */

use yii\bootstrap5\Html;
use yii\helpers\Url;
use Buyandsell\Tickets;
use app\assets\AppAsset;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/img/favicon.ico')]);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="header <?=(!Yii::$app->user->isGuest) ? 'header--logged' : ''; ?>">
  <div class="header__wrapper">
    <a class="header__logo logo" href="<?= Url::home(); ?>">
      <img src="/img/logo.svg" width="179" height="34" alt="Логотип Куплю Продам">
    </a>
    <nav class="header__user-menu">
      <ul class="header__list">
        <li class="header__item">
          <a href="<?= Url::to(['/my']); ?>">Публикации</a>
        </li>
        <li class="header__item">
          <a href="<?= Url::to(['/my/comments']); ?>">Комментарии</a>
        </li>
      </ul>
    </nav>
    <form class="search" method="get" action="<?= Url::to(['/search']); ?>" autocomplete="off">
      <input type="search" name="query" placeholder="Поиск" aria-label="Поиск" value ="<?php (Yii::$app->request->getIsget()) ?? Html::encode(trim(Yii::$app->request->get(name: 'query'))) ?>">
      <div class="search__icon"></div>
      <div class="search__close-btn"></div>
    </form>
    <?php if (isset(Yii::$app->user->getIdentity()->avatar)) : ?>
    <a class="header__avatar avatar" href="<?= Url::to(['/my']); ?>">
      <img src="<?= Html::encode(Yii::$app->user->getIdentity()->avatar); ?>.jpg" srcset="<?= Html::encode(Yii::$app->user->getIdentity()->avatar); ?>@2x.jpg 2x" alt="Аватар <?= Html::encode(Yii::$app->user->getIdentity()->name); ?>">
    </a>
    <?php endif; ?>
    <a class="header__input" href="<?= Url::to(['/login']); ?>">Вход и регистрация</a>
  </div>
</header>

<main class="page-content">
<?= $content; ?> 
</main>

<footer class="page-footer">
  <div class="page-footer__wrapper">
    <div class="page-footer__col">
      <a href="<?= Url::to('https://htmlacademy.ru'); ?>" class="page-footer__logo-academy" aria-label="Ссылка на сайт HTML-Академии">
        <svg width="132" height="46">
          <use xlink:href="/img/sprite_auto.svg#logo-htmlac"></use>
        </svg>
      </a>
      <p class="page-footer__copyright">© 2019 Проект Академии</p>
    </div>
    <div class="page-footer__col">
      <a href="<?= Url::home(); ?>" class="page-footer__logo logo">
        <img src="/img/logo.svg" width="179" height="35" alt="Логотип Куплю Продам">
      </a>
    </div>
    <div class="page-footer__col">
      <ul class="page-footer__nav">
        <?php if (Yii::$app->user->isGuest) : ?>
        <li>
          <a href="<?= Url::to(['/login']); ?>">Вход и регистрация</a>
        </li>
        <?php endif; ?>
        <?php if (!Yii::$app->user->isGuest) : ?>
        <li>
          <a href="<?= Url::to(['offers/add']); ?>">Создать объявление</a>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</footer>

<script src="/js/vendor.js"></script>
<script src="/js/main.js"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
