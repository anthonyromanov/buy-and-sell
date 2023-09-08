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

<section class="sign-up">
      <h1 class="visually-hidden">Регистрация</h1>
      <?php $form = ActiveForm::begin([
                    'id' => 'registration-form',
                    'options' => [
                      'class' => 'sign-up__form form',
                      'enctype' => 'multipart/form-data'
                    ],
                ]);
?>
        <div class="sign-up__title">
          <h2>Регистрация</h2>
          <a class="sign-up__link" href="<?= Url::to(['/login']); ?>">Вход</a>
        </div>
        <div class="sign-up__avatar-container js-preview-container">
          <div class="sign-up__avatar js-preview">
          <?php if (isset($model->avatar) && !empty($model->avatar)) : ?>
            <img src="<?= Html::encode($model->avatar); ?>.jpg" srcset="<?= Html::encode($model->avatar); ?>@2x.jpg 2x" alt="Автар <?= Html::encode($model->name); ?>"></div>
          <?php endif; ?>
          </div>
          <?= $form->field($model, 'avatar', [
            'enableAjaxValidation' => true, 'template' => "{input}\n{error}", 'options' => [
            'class' => 'sign-up__field-avatar']])
                ->fileInput(['id' => 'button-input', 'hidden' => 'hidden'])
                ->label((isset($model->avatar)) ? 'Загрузить другое фото…' : 'Загрузить фото…', ['for' => 'button-input', 'class' => 'js-file-field']); ?>
        </div>
        <?php echo $form->field($model, 'name', [
        'enableAjaxValidation' => true, 'template' => "{input}\n{error}", 'options' => [
        'class' => 'form__field sign-up__field'], 'inputOptions' => ['placeholder' => 'Имя и фамилия']])->textInput();
?>
        <?php echo $form->field($model, 'email', [
        'enableAjaxValidation' => true, 'template' => "{input}\n{error}", 'options' => [
        'class' => 'form__field sign-up__field'], 'inputOptions' => ['placeholder' => 'Электронная почта']])->input('email');
?>
          <?php echo $form->field($model, 'password', [
            'enableAjaxValidation' => true, 'template' => "{input}\n{error}", 'options' => [
            'class' => 'form__field sign-up__field'], 'inputOptions' => ['placeholder' => 'Пароль']])->passwordInput();
?>
          <?php echo $form->field($model, 'repeat_password', [
            'enableAjaxValidation' => true, 'template' => "{input}\n{error}", 'options' => [
            'class' => 'form__field sign-up__field'], 'inputOptions' => ['placeholder' => 'Повтор пароля']])->passwordInput();
?>        
        <?= Html::submitInput('Создать аккаунт', ['class' => 'sign-up__button btn btn--medium js-button']); ?>

        <?php $authAuthChoice = AuthChoice::begin([
          'baseAuthUrl' => ['site/auth'],
          'popupMode' => false,
        ]); ?>
        <?php foreach ($authAuthChoice->getClients() as $client) : ?>
          <a><?= $authAuthChoice->clientLink($client, 'Войти с <span class="icon icon--vk"></span>', ['class' => 'btn btn--small btn--flex btn--white']) ?></a>
        <?php endforeach; ?>
        <?php AuthChoice::end(); ?>
      <?php ActiveForm::end(); ?>
    </section>
    
