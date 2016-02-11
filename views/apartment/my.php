<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Apartments';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="apartment-index">

    <h1><?php Html::encode($this->title) ?></h1>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'pjax' => true,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
//            'id',
            'image_link:image',
//                [
//                    'label'=>'Image',
//                    'format' => 'raw',
//                    'value'=>function ($data) {
//                        return Html::img($data->image_link,['width'=>'206px']);
//                    },
//                ],
//            'title',
            [
                'label'=>'Title',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->title,$data->url,['target'=>'_blank']).'<br> '.$data->address;
                },
            ],
//                'like',
//            'query_id',
//            'description',
            'price',
//                'address',
            'date',
            // 'show_on_map',
            // 'html',
//             'query.name',
            // 'author_id',
            // 'updater_id',
            // 'created_at',
            // 'updated_at',
//                ['class' => '\kartik\grid\ActionColumn'],
            [
                'class' => '\kartik\grid\ActionColumn',
                'header'=>'Action',
//                'vAlign'=> GridView::ALIGN_CENTER,
                'template' => '{modal}{view}{update}{delete}',
                'headerOptions' => ['width' => '20px',],
                'contentOptions' => ['class' => 'padding-left-5px'],
                'buttons' => [
                    'modal' => function ($url, $model, $key) {
                        return Html::a('<span class="glyphicon glyphicon-modal-window text-success"></span>',['details','id'=>$model->id], [
                            'onclick'=>"$('#modal').modal('show').find('.modal-body').load($(this).attr('href'));return false",
                            'data-pjax' => '0',
//                            'class'=>'btn btn-lg'
                        ]);
                    },
                ]
            ]

        ],
    ]);
    ?>

    <?php
    yii\bootstrap\Modal::begin([
        'id' =>'modal',
        'size' => \yii\bootstrap\Modal::SIZE_LARGE,
        'header' => '<h4 class="modal-title">View</h4>',
        'footer' => '<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>',
    ]);
    yii\bootstrap\Modal::end();
    ?>
