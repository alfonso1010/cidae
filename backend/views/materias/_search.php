<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MateriasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="materias-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_materia') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'clave') ?>

    <?= $form->field($model, 'total_creditos') ?>

    <?= $form->field($model, 'periodo') ?>

    <?php // echo $form->field($model, 'mes_periodo') ?>

    <?php // echo $form->field($model, 'id_carrera') ?>

    <?php // echo $form->field($model, 'fecha_alta') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
