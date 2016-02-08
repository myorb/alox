<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Apartment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apartment-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'description') ?>

    <?= $form->field($model, 'price') ?>

    <?= $form->field($model, 'address') ?>

    <?= $form->field($model, 'show_on_map') ?>

    <?= $form->field($model, 'html') ?>

    <?= $form->field($model, 'query_id')->dropDownList(
        \yii\helpers\ArrayHelper::map(\app\models\Query::find()->all(), 'id', 'name')
    ) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
