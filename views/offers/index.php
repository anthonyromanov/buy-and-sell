<?php

use yii\helpers\Html;
use Buyandsell\Tickets;
use yii\widgets\ListView;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

$this->registerJsFile(
    'https://www.gstatic.com/firebasejs/10.3.1/firebase-app.js',
    [
    'position' => \yii\web\View::POS_BEGIN]
);

$this->registerCssFile(
    '/css/custom.css'
  );  

?>

<section class="ticket">
    <div class="ticket__wrapper">
        <h1 class="visually-hidden">Карточка объявления</h1>
        <div class="ticket__content">
            <div class="ticket__img">
                <?php if (isset($ticket->picture) && !empty($ticket->picture)) : ?>
                <img src="<?= Html::encode($ticket->picture); ?>.jpg" srcset="<?= Html::encode($ticket->picture); ?>.jpg 2x" alt="Изображение <?= Html::encode($ticket->title); ?>">
                <?php endif; ?>
            </div>
            <div class="ticket__info">
                <h2 class="ticket__title"><?= Html::encode($ticket->title); ?></h2>
                <div class="ticket__header">
                    <p class="ticket__price">
                        <span class="js-sum"><?= Html::encode(Yii::$app->formatter->asDecimal($ticket->price)); ?></span> ₽
                    </p>
                    <p class="ticket__action"><?= Tickets::getTicketType(Html::encode($ticket->type)); ?></p>
                </div>
                <div class="ticket__desc">
                    <p><?= Html::encode($ticket->description); ?></p>
                </div>
                <div class="ticket__data">
                    <p>
                        <b>Дата добавления:</b>
                        <span><?= Yii::$app->formatter->asDate($ticket->creation); ?></span>
                    </p>
                    <p>
                        <b>Автор:</b>
                        <a href="#"><?= Html::encode($ticket->user->name); ?></a>
                    </p>
                    <p>
                        <b>Контакты:</b>
                        <a href="mailto:<?= Html::encode($ticket->user->email); ?>"><?= Html::encode($ticket->user->email); ?></a>
                    </p>
                </div>
                <ul class="ticket__tags">
                <?php foreach (Tickets::getCategoriesToTicket($ticket->id) as $category): ?>
                     <li>
                        <a href="<?= Url::to(['/offers/category', 'id' => $category->id]); ?>" class="category-tile category-tile--small">
                            <span class="category-tile__image">
                                <img src="<?= Html::encode($category->path); ?>.jpg" srcset="<?= Html::encode($category->path); ?>@2x.jpg 2x" alt="Иконка категории">
                            </span>
                            <span class="category-tile__label"><?= Html::encode($category->label); ?></span>
                        </a>
                    </li>
                <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="ticket__comments">
        <?php if (!Yii::$app->user->can('canUser')) : ?>
                <div class="ticket__warning">
                    <p>Отправка комментариев доступна <br>только для зарегистрированных пользователей.</p>
                    <a href="<?= Url::to(['/login']); ?>" class="btn btn--big">Вход и регистрация</a>
                </div>
            <?php endif; ?>

            <?php if (Yii::$app->user->can('canUser')) : ?>
            <h2 class="ticket__subtitle">Коментарии</h2>
            <div class="ticket__comment-form">
            <?php $form = ActiveForm::begin([
                    'id' => 'comment-form',
                    'options' => ['class' => 'form comment-form'],
                ]);
            ?>
                <div class="comment-form__header">
                    <a href="#" class="comment-form__avatar avatar">
                        <img src="<?= Html::encode(Yii::$app->user->getIdentity()->avatar); ?>.jpg" srcset="<?= Html::encode(Yii::$app->user->getIdentity()->avatar); ?>@2x.jpg 2x" alt="Аватар пользователя">
                    </a>
                    <p class="comment-form__author"><?= Html::encode(Yii::$app->user->getIdentity()->name); ?></p>
                </div>

                <div class="comment-form__field">
                    <?php echo $form->field($commentForm, 'comment', ['template' => "{input}\n{label}\n{error}", 'options' => [
                    'class' => 'form__field']])->textarea(['options' => ['class' => 'js-field', 'autocorrect' => 'off',
                    'autocomplete' => 'off', 'autocapitalize' => 'off']]); ?>
                </div>
                <?= Html::submitInput('Отправить', ['class' => 'comment-form__button btn btn--white js-button']); ?>
            <?php ActiveForm::end(); ?>
            </div>
            <?php endif; ?>
            <?php if (!isset($commentsCount) || $commentsCount === 0) : ?> 
            <div class="ticket__message">
                <p>У этой публикации еще нет ни одного комментария.</p>
            </div>
            <?php endif; ?>
            <?php if (isset($commentsCount) && $commentsCount !== 0) : ?>
            <div class="ticket__comments-list">
                <?php
                    echo ListView::widget([
                        'dataProvider' => $comments,
                        'itemView' => 'commentsList',
                        'itemOptions' => [
                        'tag' => false,
                        ],
                        'layout' => '{items}',
                        'emptyText' => false,
                        'options' => [
                            'tag' => 'ul',
                            'class' => 'comments-list',
                        ],
                    ]);
                ?>
            </div>
            <?php endif; ?>
        </div>
        <button class="chat-button" type="button" aria-label="Открыть окно чата"></button>
    </div>
</section>

<?php if (Yii::$app->user->can('canUser')) : ?>
<section class="chat visually-hidden">
    <iframe class="chating" src="/chat.php">
    </iframe>
</section>
<?php endif;?>
