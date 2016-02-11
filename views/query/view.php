<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\widgets\SwitchInput;

/* @var $this yii\web\View */
/* @var $model app\models\Query */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Queries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="query-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Create Query', ['create'], ['class' => 'btn btn-success']) ?>
        <?= Html::a('Upload Results ->', ['apartment/index','ApartmentSearch'=>['query_id'=>$model->id]], ['class' => 'btn btn-info']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'author.username',
//            'updater_id',
            'created_at:date',
            'updated_at:date',
        ],
    ]);

    ?>

</div>
