<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */

//$this->title = $model->title;
//$this->params['breadcrumbs'][] = ['label' => 'Apartments', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div>
    <div class="clear-fix"></div>
    <div class="apartment-view">

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
//                'id',
                'title',
                [
                    'label'=>'title',
                    'format' => 'raw',
                    'value'=>function ($data) {
                        return Html::a($data->title,$data->url,['target'=>'_blank']);
                    },
                ],
//            'description',
                'price',
//            'address',
//            'show_on_map',
//            'html',
//            'query.name',
//            'author_id',
//            'updater_id',
//            'created_at:date',
//            'updated_at:date',
            ],
        ]) ?>
        <?=$model->html?>



    </div>
</div>