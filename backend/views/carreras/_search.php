<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CarrerasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="carreras-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_carrera') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'clave') ?>

    <?= $form->field($model, 'rvoe') ?>

    <?= $form->field($model, 'total_periodos') ?>

    <?php // echo $form->field($model, 'fecha_alta') ?>

    <?php // echo $form->field($model, 'activo') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
