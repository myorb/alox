<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel app\models\search\ApartmentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Apartments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="apartment-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Apartment', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Reload', ['reload'], ['class' => 'btn btn-info']) ?>
    </p>
<?php
//var_dump($dataProvider->getModels());
Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'title',
//            'description',
            'price',
            'address',
            // 'show_on_map',
            // 'html',
             'query.name',
            // 'author_id',
            // 'updater_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
