<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * Created by PhpStorm.
 * User: alex
 * Date: 15.02.16
 * Time: 19:45
 */


$this->title = 'Likes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="customer-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'apartment_id',
            [
                'label'=>'Olx link',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->title,$data->url,['target'=>'_blank']);
                },
            ],
            'url:url',
//            'registration_date',
//            'author_id',
            // 'updater_id',
            // 'created_at',
            // 'updated_at',

//            ['class' => 'yii\grid\ActionColumn','template'=>'{delete}',],
            [
                'class' => 'yii\grid\ActionColumn',
                'header'=>'Action',
                'template' => '{delete}{up}',
                'headerOptions' => ['width' => '20px',],
                'contentOptions' => ['class' => 'padding-left-5px'],
                'buttons' => [
                    'up' => function ($url, $model, $key) {
                        $html = '<span class="glyphicon glyphicon-thumbs-up"></span>';
                        return Html::a( $html,['up','id'=>$model->id], [
                            'onclick'=>"$.get($(this).attr('href')).done(function(data){alert(data);});return false",
                            'data-pjax' => '0',
                            'class'=>'btn btn-lg '
                        ]);
                    },
                ],
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
