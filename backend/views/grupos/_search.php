<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\GruposSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="grupos-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_grupo') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'generacion') ?>
    
    <?= $form->field($model, 'modalidad') ?>

    <?= $form->field($model, 'capacidad') ?>

    <?= $form->field($model, 'id_carrera') ?>

    <?php // echo $form->field($model, 'no_evaluaciones_periodo') ?>

    <?php // echo $form->field($model, 'fecha_alta') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
