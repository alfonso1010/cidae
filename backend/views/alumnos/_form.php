<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;
use kartik\widgets\Select2;
/* @var $this yii\web\View */
/* @var $model common\models\Alumnos */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="alumnos-form">
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
                         <?= $form->field($model, 'id_grupo')->widget(Select2::classname(), [
                            'data' => $grupos,
                            'options' => ['placeholder' => 'Seleccione Grupo'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label("Grupo") ?>
                    </div>
                     <div class="col-sm-4">
                        <?= $form->field($model, 'matricula')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'curp')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'apellido_paterno')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'apellido_materno')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefono_celular')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefono_casa')->textInput(['maxlength' => true]) ?>
                    </div>
                     <div class="col-sm-4">
                        <?= $form->field($model, 'direccion')->textarea(['rows' => 4]) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'sexo')->dropDownList(
                            ["M" => "Masculino", "F" => "Femenino"],
                            [
                                'prompt' => 'Seleccione',
                                'class'  => 'form form-control'
                            ]);
                        ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'edad')->textInput() ?>
                    </div>
                </div>
            </div>
           
            <div class="row">
                <div class="col-xs-12">
                     <div class="col-sm-4 col-md-4 col-lg-4 fecha_nacimiento">
                        <label class="control-label">Fecha Nacimiento</label>
                        <?php
                            echo DatePicker::widget([
                                'model'=>$model,
                                'attribute'=>'fecha_nacimiento',
                                'type' => DatePicker::TYPE_INPUT,
                                'options' => [
                                    'placeholder' => 'Elige Fecha de Nacimiento',
                                    'required' => true,
                                    'value' => (strlen($model->fecha_nacimiento) > 0)?$model->fecha_nacimiento:"1995-01-01"
                                ],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                ],
                            ]);
                        ?>
                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 fecha_ingreso">
                        <label class="control-label">Fecha Ingreso</label>
                        <?php
                            echo DatePicker::widget([
                                'model'=>$model,
                                'attribute'=>'fecha_ingreso',
                                'type' => DatePicker::TYPE_INPUT,
                                'options' => [
                                    'placeholder' => 'Seleccione Fecha Ingreso',
                                    'required' => true,
                                    'value' => (strlen($model->fecha_ingreso) > 0)?$model->fecha_ingreso:date("Y-m-d")
                                ],
                                'pluginOptions' => [
                                    'autoclose'=>true,
                                    'format' => 'yyyy-mm-dd',
                                ],
                            ]);
                        ?>
                    </div>
                </div>
            </div>
            <br>

             <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'nombre_contacto_emergencia')->textInput(['maxlength' => true]) ?>
                    </div>
                    <div class="col-sm-4">
                        <?= $form->field($model, 'telefono_contacto_emergencia')->textInput(['maxlength' => true]) ?>
                    </div>
                     <div class="col-sm-4">
                        <?= $form->field($model, 'direccion_contacto_emergencia')->textarea(['rows' => 4]) ?>
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