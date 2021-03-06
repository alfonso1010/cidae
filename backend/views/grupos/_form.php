<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Grupos */
/* @var $form yii\widgets\ActiveForm */


?>

<div class="grupos-form">
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
                        <?= $form->field($model, 'id_carrera')->widget(Select2::classname(), [
                            'data' => $carreras,
                            'options' => ['placeholder' => 'Seleccione Carrera'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label("Carrera") ?>
                    </div>
                </div>
            </div>
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
                       <?= $form->field($model, 'generacion')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div> 
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <label class="control-label">Fecha Inicio Clases</label>
                        <?php
                            echo DatePicker::widget([
                                'model'=>$model,
                                'attribute'=>'fecha_inicio_clases',
                                'type' => DatePicker::TYPE_INPUT,
                                'options' => [
                                    'placeholder' => 'Seleccione Fecha Inicio Clases',
                                    'required' => true,
                                     'value' => (strlen($model->fecha_inicio_clases) > 0)?$model->fecha_inicio_clases:date("Y-m-d")
                                ],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                ],
                            ]);
                        ?>
                        <br>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'modalidad')->widget(Select2::classname(), [
                            'data' => ['Escolarizado' => "Escolarizado",'Sabatino' => "Sabatino"],
                            'options' => ['placeholder' => 'Seleccione modalidad'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label("Modalidad") ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'capacidad')->textInput() ?>
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
