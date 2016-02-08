<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Query */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="query-form">

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'url') ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
