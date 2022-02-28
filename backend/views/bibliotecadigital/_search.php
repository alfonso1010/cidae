<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\BibliotecaDigitalSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="biblioteca-digital-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_libro') ?>

    <?= $form->field($model, 'categoria') ?>

    <?= $form->field($model, 'nombre_libro') ?>

    <?= $form->field($model, 'autor') ?>

    <?= $form->field($model, 'editorial') ?>

    <?php // echo $form->field($model, 'ruta_libro') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'estatus') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <?php // echo $form->field($model, 'imagen_portada') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
