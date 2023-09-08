<?php

use yii\helpers\Html;
use Buyandsell\Tickets;
use yii\widgets\ActiveForm;

$this->title = 'Куплю Продам';

$this->registerCssFile(
  '/css/custom.css'
);

?>

<section class="ticket-form">
    <div class="ticket-form__wrapper">
      <h1 class="ticket-form__title">Новая публикация</h1>
      <div class="ticket-form__tile">
        <?php $form = ActiveForm::begin([
          'id' => 'ticket-form',
          'options' => ['class' => 'ticket-form__form form'],
          ]);
        ?>
          <div class="ticket-form__avatar-container js-preview-container">
            <div class="ticket-form__avatar js-preview"></div>
              <?= $form->field($ticketForm, 'picture', ['template' => '{input}{label}', 'options' => [
                'class' => 'ticket-form__field-avatar']])
                ->fileInput(['id' => 'avatar', 'class' => 'visually-hidden js-file-field'])
                ->label('Загрузить фото…', ['for' => 'avatar', 'class' => 'js-file-field']); ?>
          </div>

          <div class="ticket-form__content">
            <div class="ticket-form__row">
              <?php echo $form->field($ticketForm, 'title', ['template' => "{input}\n{error}", 'options' => [
                'class' => 'form__field'], 'inputOptions' => ['placeholder' => 'Название']])->textInput(); ?>
            </div>
            <div class="ticket-form__row">
                <?php echo $form->field($ticketForm, 'description', ['template' => "{input}\n{error}", 'options' => [
                  'class' => 'form__field'], 'inputOptions' => ['placeholder' => 'Описание']])->textarea(); ?>
            </div>
            <div class="ticket-form__row">
            <?php echo $form->field($ticketForm, 'categories[]', ['template' => "{input}\n{error}", 'options' => ['tag' => false]])
                ->dropDownList($categories, ['class' => 'form__select js-multiple-select',  'data-label' => 'Выберите категорию публикации']);
            ?>
            </div>
            <div class="ticket-form__row">
              <?php echo $form->field($ticketForm, 'price', ['template' => "{input}\n{error}", 'options' => [
                'class' => 'form__field form__field--price'], 'inputOptions' => ['placeholder' => 'Цена']])->textInput(); ?>

              <div class="form__switch switch">
                <? echo $form->field($ticketForm, 'type', ['template' => "{input}\n{label}\n{error}", 'options' => ['class' => 'switch__item'],
                'inputOptions' => ['class' => 'visually-hidden', 'type' => 'radio', 'id' => 'buy-field', 'value' => 'buy'],
                'labelOptions' => ['class' => 'switch__button', 'label' => 'Куплю']]); ?>
                <? echo $form->field($ticketForm, 'type', ['template' => "{input}\n{label}\n{error}", 'options' => ['class' => 'switch__item'],
                'inputOptions' => ['class' => 'visually-hidden', 'type' => 'radio', 'id' => 'sell-field', 'value' => 'sell'],
                'labelOptions' => ['class' => 'switch__button', 'label' => 'Продам']]); ?>
              </div>

          </div>
          <?= Html::submitInput('Опубликовать', ['class' => 'form__button btn btn--medium js-button']); ?>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </section>


  