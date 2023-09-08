<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Ticket;
use app\models\Category;
use Buyandsell\Tickets;
use yii\helpers\StringHelper;

?>

<?php if (!empty(Tickets::getCategoryTickets($model->id))) : ?>
<li class="categories-list__item">
  <a href="<?= Url::to(['/offers/category', 'id' => $model->id]); ?>" class="category-tile category-tile--default">
    <span class="category-tile__image">
      <img src="<?= Html::encode($model->path);?>.jpg" srcset="<?= Html::encode($model->path);?>@2x.jpg 2x" alt="Иконка категории">
    </span>
    <span class="category-tile__label"><?= Html::encode($model->label);?> <span class="category-tile__qty js-qty"><?= Html::encode(Tickets::getCategoryTickets($model->id)) ;?> </span></span>
  </a>
</li>
<?php endif; ?>      
