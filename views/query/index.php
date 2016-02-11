<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\QuerySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Queries';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="query-index">
    <h1><?php // Html::encode($this->title) ?></h1>
    <?php

     // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?php
//        $e = \Yii::$app->session->get('user.hash');
//        var_dump($e);
        ?>

        <?= Html::a('Create Query', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div class="row">
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => false,
        'responsive'=>true,
        'layout'=>"{items}\n{pager}",
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'label'=>'Olx Link',
                'format' => 'raw',
                'width' => '60px',
                'value'=>function ($data) {
                    return Html::a('<span class="glyphicon glyphicon-link">olx</span>',$data->url,['target'=>'_blank','title'=>'olx']);
                },
            ],
            [
                'label'=>'Name',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->name,['apartment/index','ApartmentSearch'=>['query_id'=>$data->id]],['target'=>'_blank','title'=>"View"]);
                },
            ],
//            'name',
//            'url:url',

            [
                'label'=>'Total',
                'format' => 'raw',
                'value'=>function ($data) {
                    return count($data->apartments);
                },
            ],
//            [
//                'label'=>'AVR',
//                'format' => 'raw',
//                'value'=>function ($data) {
//                    return count($data->avarageProse);
//                },
//            ],
            [
                'label'=>'New',
                'format' => 'raw',
                'value'=>function ($data) {
                    return count($data->apartments);
                },
            ],
//            'author.username',
//            'author_id',
//            'updater_id',
//             'created_at:date',

//            [
//                'label'=>'Auto Update',
//                'format' => 'raw',
//                'value'=>function ($data) {
//                    return count($data->apartments);
//                },
//            ],
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
    </div>
</div>
