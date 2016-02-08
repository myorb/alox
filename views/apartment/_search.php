<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\search\ApartmentSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apartment-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?php // echo $form->field($model, 'id') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'show_on_map') ?>

    <?php // echo $form->field($model, 'html') ?>

    <?php  echo $form->field($model, 'query_id')->dropDownList(\yii\helpers\ArrayHelper::map(\app\models\Query::find()->all(), 'id', 'name')) ?>

    <?php // echo $form->field($model, 'author_id') ?>

    <?php // echo $form->field($model, 'updater_id') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
        <?= Html::a('Reload', ['reload'], ['class' => 'btn btn-info', 'id' => 'refreshButton']) ?><span id="totalUpdate" class="badge"></span>

    </div>

    <?php ActiveForm::end(); ?>

</div>
