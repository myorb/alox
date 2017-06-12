<?php
use kartik\helpers\Html;
/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.02.16
 * Time: 20:38
 */
?>
<div class="grid-ap-index">
    <div class="row">
        <?php foreach(array_chunk($dataProvider->getModels(),4) as $v): ?>
            <?php foreach($v as $model): ?>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb portfolio-item">
                    <?=\yii\bootstrap\Html::a(
                        '<b class="grid-price">'.$model->fullprice.'</b>'.
                        \yii\bootstrap\Html::img(
                            $model->image_link?
                                $model->image_link:
                                'http://placehold.it/400x300',
                            ['height'=>'200px','style'=>['max-height'=>'200px','min-height'=>'200px']]).
                        '<span class="title">'.$model->title.'</span>',
//                Html::a('<span class="glyphicon glyphicon-link"></span>',$model->url,['target'=>'_blank','title'=>'olx']),
                        ['details','id'=>$model->id],
                        [
                            'class'=>"thumbnail",
                            'onclick'=>"$('#modal').modal('show').find('.modal-body').load($(this).attr('href'));return false",
                        ]
                    )
                    ?>
                </div>
            <?php endforeach ?>
            <div class="clearfix"></div>
        <?php endforeach ?>
    </div>
</div>




