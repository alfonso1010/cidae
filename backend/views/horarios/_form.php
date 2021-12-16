<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Horarios */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="horarios-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id_grupo')->textInput() ?>

    <?= $form->field($model, 'turno')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
