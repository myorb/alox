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
            'apartment.title',
            'apartment.url:url',
//            'registration_date',
//            'author_id',
            // 'updater_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
