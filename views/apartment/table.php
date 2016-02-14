<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 13.02.16
 * Time: 20:38
 */
echo GridView::widget([
    'dataProvider' => $dataProvider,
//    'filterModel' => $searchModel,
    'layout'=>"{items}\n{pager}",
    'filterModel' => false,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
//            'id',
//                'image_link:image',
        [
            'label'=>'Image',
//                    'headerOptions' => ['width' => '20px',],
//                    'width'=>'36px',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::img($data->image_link,['width'=>'230','height'=>'180']);
            },
        ],
//            'title',
        [
            'label'=>'Title',
            'format' => 'raw',
            'value'=>function ($data) {
                return Html::a($data->title,$data->url,['target'=>'_blank']).'<br> '.$data->address;
            },
        ],
//                [
//                    'label'=>'Price',
//                    'format' => 'raw',
//                    'value'=>function ($data) {
//                        return Html::a($data->title,$data->url,['target'=>'_blank']).'<br> '.$data->address;
//                    },
//                ],
//            'query_id',
//            'description',
//        'fullprice',
//        [
//            'label'=>'Price',
//            'filter'=>'price',
//            'format' => 'raw',
//            'value'=>function ($data) {
//                return $data->fullprice;
//            },
//        ],

        [
            'attribute'=>'price',
            'width'=>'70px',
            'value'=>function ($model) {
                return $model->fullprice;
            },
        ],
        [
            'attribute'=>'date',
            'width'=>'70px',
            'value'=>function ($model) {
                return $model->dateformated;
            },
        ],

//        'price',
//                'address',
//        'date:date',
//        'dateformated',
//        'datetwo',
        // 'show_on_map',
        // 'html',
//             'query.name',
        // 'author_id',
        // 'updater_id',
        // 'created_at',
        // 'updated_at',
//                ['class' => 'yii\grid\ActionColumn'],
        [
            'class' => 'yii\grid\ActionColumn',
            'header'=>'Action',
            'template' => '{modal}{like}{remove}{view}',
            'headerOptions' => ['width' => '20px',],
            'contentOptions' => ['class' => 'padding-left-5px'],
            'buttons' => [
                'modal' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-modal-window text-success"></span>',['details','id'=>$model->id], [
                        'onclick'=>"$('#modal').modal('show').find('.modal-body').load($(this).attr('href'));return false",
                        'data-pjax' => '0',
                        'class'=>'btn btn-lg'
                    ]);
                },
                'like' => function ($url, $model, $key) {
                    $html = $model->like?
                        '<span class="glyphicon glyphicon-thumbs-down"></span>':
                        '<span class="glyphicon glyphicon-thumbs-up"></span>';
                    return Html::a( $html,['like','id'=>$model->id], [
                        'onclick'=>"$.get($(this).attr('href')).done(function(data){if(data=='ok')$(this).toggleClass('glyphicon-thumbs-up', 'glyphicon-thumbs-down')});$.pjax.reload('#apartments');return false",
                        'data-pjax' => '0',
                        'class'=>'btn btn-lg '
                    ]);
                },
                'remove' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-trash "></span>',['delete','id'=>$model->id], [
                        'title' => Yii::t('yii', 'Delete'),
                        'aria-label' => Yii::t('yii', 'Delete'),
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                        'class'=>'btn btn-lg '
                    ]);
                },
                'view' => function ($url, $model, $key) {
                    return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',['view','id'=>$model->id], [
                        'title' => Yii::t('yii', 'View'),
                        'aria-label' => Yii::t('yii', 'View'),
                        'data-pjax' => '0',
                        'class'=>'btn btn-lg'
                    ]);
                },

            ],
        ],
//                [
//                    'class' => 'yii\grid\ActionColumn',
//                    'template' => '{like}',
//                    'header'=>'Like',
////                    'headerOptions' => ['width' => '20%',],
////                    'contentOptions' => ['class' => 'padding-left-5px'],
//                    'buttons' => [
//                        'like' => function ($url, $model, $key) {
//                            return Html::a('<span class="glyphicon glyphicon-star"></span>',['details','id'=>$model->id], [
//                                'onclick'=>"$('#modal').modal('show').find('.modal-body').load($(this).attr('href'));return false",
//                                'data-pjax' => '0',
//                                'class'=>'btn btn-lg'
//                            ]);
//                        },
//                    ],
//                ],
    ],
]);