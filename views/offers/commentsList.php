<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<li>
    <div class="comment-card">
        <div class="comment-card__header">
            <a href="<?= Url::to(['/my']); ?>" class="comment-card__avatar avatar">
                <img src="<?= Html::encode($model->user->avatar); ?>.jpg" srcset="<?= Html::encode($model->user->avatar); ?>@2x.jpg 2x" alt="Аватар пользователя">
            </a>
            <p class="comment-card__author"><?= Html::encode($model->user->name);?></p>
        </div>
        <div class="comment-card__content">
            <p><?= Html::encode($model->comment);?></p>
        </div>
    </div>
</li>
