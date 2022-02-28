<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model common\models\Avisos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="avisos-form">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <?php 
                $form = ActiveForm::begin(); 
                echo $form->errorSummary($model);
            ?>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                         <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
           
             <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'file_aviso')->fileInput()->label("Imagen de Aviso"); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-5"></div>
                    <div class="col-sm-4">
                        <?= Html::submitButton('Guardar', ['class' => 'btn btn-success']) ?>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
