<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */

?>
<div class="clear-fix"></div>
<div class="apartment-view">
    <script>
        $(function() {
            $('#modal').find('.modal-title').html('<?=Html::a($model->title."  за: <b> ".$model->fullprice."</b>" ,$model->url,['target'=>'_blank']) ?>');
        });
    </script>
    <div class="col-md-12">
        <div class="well well-sm">
            <div class="btn-group btn-group-justified" role="group" aria-label="...">
                <div class="btn-group" role="group">
                    <?php $html = count($model->likes)?
                        '<span class="glyphicon glyphicon-thumbs-down"></span>':
                        '<span class="glyphicon glyphicon-thumbs-up"></span>';
                    echo Html::a( $html,[count($model->likes)?'unlike':'like','id'=>$model->id], [
                        'onclick'=>"$.get($(this).attr('href')).done(function(data){if(data=='ok')$(this).toggleClass('glyphicon-thumbs-up', 'glyphicon-thumbs-down')});return false",
                        'data-pjax' => '0',
                        'class'=>'btn btn-lg '
                    ]);
                    ?>
<!--                    <button type="button" class="btn btn-default">Like</button>-->
                </div>
                <div class="btn-group" role="group">
                    <?=Html::a('<span class="glyphicon glyphicon-trash "></span>',['delete','id'=>$model->id], [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                        'class'=>'btn btn-lg '
                    ]);?>
<!--                    <button type="button" class="btn btn-default">Save</button>-->
                </div>
                <div class="btn-group" role="group">
<!--                    <button type="button" class="btn btn-default">Don`t show</button>-->
                </div>
            </div>
        </div>
    </div>

    <?php
    //        DetailView::widget([
    //            'model' => $model,
    //            'attributes' => [
    ////                'id',
    //                [
    //                    'label' => 'Title',
    //                    'format' => 'raw',
    //                    'value' => Html::a($model->title,$model->url,['target'=>'_blank']),
    //                ],
    //                'fullprice',
    //                'date:datetime'
    //            ],
    //        ])
    ?>

    <?php echo$model->html ?>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'label' => 'Title',
                'format' => 'raw',
                'value' => Html::a($model->title,$model->url,['target'=>'_blank']),
            ],
            'fullprice',
            'date:datetime'
        ],
    ]) ?>


</div>
</div>