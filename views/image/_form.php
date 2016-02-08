<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Image */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="image-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'model_name') ?>

    <?= $form->field($model, 'model_id') ?>

    <?= $form->field($model, 'file') ?>

    <?= $form->field($model, 'path') ?>

    <?= $form->field($model, 'link') ?>

    <?= $form->field($model, 'author_id') ?>

    <?= $form->field($model, 'updater_id') ?>

    <?= $form->field($model, 'created_at') ?>

    <?= $form->field($model, 'updated_at') ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
