<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */

?>
<div>
    <div class="clear-fix"></div>
    <div class="apartment-view">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
                [
                    'label' => 'Title',
                    'format' => 'raw',
                    'value' => Html::a($model->title,$model->url,['target'=>'_blank']),
                ],
                'price',
                'date:datetime'
            ],
        ]) ?>
        <?php echo$model->html ?>
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'label' => 'Title',
                    'format' => 'raw',
                    'value' => Html::a($model->title,$model->url,['target'=>'_blank']),
                ],
                'price',
                'date:datetime'
            ],
        ]) ?>


    </div>
</div>