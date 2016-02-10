<?php

use yii\helpers\Html;
use yii\grid\GridView;
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
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => false,
//        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'label'=>'Name',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->name,['apartment/index','ApartmentSearch'=>['query_id'=>$data->id]],['target'=>'_blank']);
                },
            ],
//            'name',
//            'url:url',
            [
                'label'=>'Url',
                'format' => 'raw',
                'value'=>function ($data) {
                    return Html::a($data->url,$data->url,['target'=>'_blank']);
                },
            ],
            [
                'label'=>'Total',
                'format' => 'raw',
                'value'=>function ($data) {
                    return count($data->apartments);
                },
            ],
//            'author.username',
            'author_id',
//            'updater_id',
             'created_at:date',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
