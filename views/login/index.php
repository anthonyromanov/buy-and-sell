<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\authclient\widgets\AuthChoice;

$this->title = 'Куплю Продам';

$this->registerCssFile(
    '/css/custom.css'
);


?>

<section class="login">
<h1 class="visually-hidden">Логин</h1>
<?php $form = ActiveForm::begin([
  'id' => 'login-form',
  'options' => [
  'class' => 'login__form form',
  'autocomplete' => 'off'
  ],
  ]);
?>
<div class="login__title">
  <a class="login__link" href="<?= Url::to(['/registration']); ?>">Регистрация</a>
  <h2>Вход</h2>
</div>
<?php echo $form->field($model, 'email', [
'enableAjaxValidation' => true, 'template' => "{input}\n{error}", 'options' => [
'class' => 'form__field login__field'], 'inputOptions' => ['placeholder' => 'Электронная почта']])->input('email');
?>
<?php echo $form->field($model, 'password', [ 'template' => "{input}\n{error}", 'options' => [
'class' => 'form__field login__field'], 'inputOptions' => ['placeholder' => 'Пароль']])->passwordInput();
?>

<?= Html::submitInput('Войти', [
'class' => 'login__button btn btn--medium js-button']); ?>

<?php $authAuthChoice = AuthChoice::begin([
    'baseAuthUrl' => ['site/auth'],
    'popupMode' => false,
]); ?>
<?php foreach ($authAuthChoice->getClients() as $client) : ?>
<a>
    <?= $authAuthChoice->clientLink(
        $client,
        'Войти с <span class="icon icon--vk"></span>',
        ['class' => 'btn btn--small btn--flex btn--white']
    ) ?>
</a>
<?php endforeach; ?>
<?php AuthChoice::end(); ?>
<?php ActiveForm::end() ?>
</section>
