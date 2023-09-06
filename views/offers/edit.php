<?php

use yii\helpers\Html;
use Buyandsell\Tickets;
use yii\widgets\ActiveForm;

?>

<section class="ticket-form">
    <div class="ticket-form__wrapper">
      <h1 class="ticket-form__title">Редактировать публикацию</h1>
      <div class="ticket-form__tile">
        <?php $form = ActiveForm::begin([
          'id' => 'ticket-form',
          'options' => ['class' => 'ticket-form__form form'],
          ]);
        ?>

          <div class="ticket-form__avatar-container js-preview-container uploaded">
            <div class="ticket-form__avatar js-preview">
              <img src="<?= Html::encode($ticket->picture); ?>.jpg" srcset="<?= Html::encode($ticket->picture); ?>@2x.jpg 2x" alt="<?= Html::encode($ticket->title); ?>">
            </div>
            <?= $form->field($ticketForm, 'picture', ['template' => '{input}{label}', 'options' => [
                'class' => 'ticket-form__field-avatar']])
                ->fileInput(['class' => 'visually-hidden js-file-field'])
                ->label((isset($ticket->picture)) ? 'Загрузить другое фото…' : 'Загрузить фото…', ['class' => 'js-file-field']); ?>
          </div>
          <div class="ticket-form__content">
            <div class="ticket-form__row">
              <?php echo $form->field($ticketForm, 'title', ['template' => "{input}\n{label}\n{error}", 'options' => [
                'class' => 'form__field'], 'inputOptions' => ['class' => 'js-field', 'autocorrect' => 'off',
                'autocomplete' => 'off', 'autocapitalize' => 'off', 'value' => Html::encode($ticket->title)]])->textInput(); ?>
            </div>
            <div class="ticket-form__row">
              <?php echo $form->field($ticketForm, 'description', ['template' => "{input}\n{label}\n{error}", 'options' => [
                  'class' => 'form__field'], 'inputOptions' => ['class' => 'js-field']])->textarea(['value' => Html::encode($ticket->description)]); ?>
            </div>
            <div class="ticket-form__row">
              <?php echo $form->field($ticketForm, 'categories[]', ['template' => "{input}\n{error}", 'options' => ['tag' => false]])
                  ->dropDownList($categories, ['class' => 'form__select js-multiple-select',  'data-label' => 'Выберите категорию публикации']);
              ?>
            </div>
            <div class="ticket-form__row">
              <?php echo $form->field($ticketForm, 'price', ['template' => "{input}\n{label}\n{error}", 'options' => [
                'class' => 'form__field form__field--price'], 'inputOptions' => ['class' => 'js-field js-price', 'value' => Html::encode($ticket->price), 'type' => 'number']])->textInput(); ?>
              <div class="form__switch switch">
                <?php echo $form->field($ticketForm, 'type', ['template' => "{input}\n{label}\n{error}", 'options' => ['class' => 'switch__item'],
                'inputOptions' => ['class' => 'visually-hidden', 'type' => 'radio', 'id' => 'buy-field', 'value' => 'buy', 'checked' => ($ticket->type === Tickets::TYPE_BUY) ?? true],
                'labelOptions' => ['class' => 'switch__button', 'label' => 'Куплю']]); ?>
                <? echo $form->field($ticketForm, 'type', ['template' => "{input}\n{label}\n{error}", 'options' => ['class' => 'switch__item'],
                'inputOptions' => ['class' => 'visually-hidden', 'type' => 'radio', 'id' => 'sell-field', 'value' => 'sell', 'checked' => ($ticket->type === Tickets::TYPE_SELL) ?? true],
                'labelOptions' => ['class' => 'switch__button', 'label' => 'Продам']]); ?>
              </div>
            </div>
          </div>

          <?= Html::submitInput('Сохранить', ['class' => 'form__button btn btn--medium js-button']); ?>
        <?php ActiveForm::end(); ?>
      </div>
    </div>
  </section>
  