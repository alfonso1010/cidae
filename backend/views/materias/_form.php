<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model common\models\Materias */
/* @var $form yii\widgets\ActiveForm */



$this->registerJs("

  
", View::POS_END);

?>


<div class="carreras-form">

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
                        <?= $form->field($model, 'id_carrera')->widget(Select2::classname(), [
                            'data' => $carreras,
                            'options' => [
                                'placeholder' => 'Seleccione Carrera',
                                'id' => "selectmaterias",
                                'onchange'=>'
                                    $("#carga").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
                                    $.post( "'.urldecode(Yii::$app->urlManager->createUrl('materias/buscasemestre?id=')).'"+$(this).val(), function( data ) {
                                      $("select#semestre").html( data );
                                      $("#semestre").removeAttr("disabled");
                                      $("#carga").html("");
                                    });'
                            ],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label("Carrera") ?>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?=
                             $form->field($model, 'periodo')->widget(Select2::classname(), [
                                'data' => [],
                                'options' => [
                                    'id' => 'semestre',
                                    'placeholder' => 'Seleccione semestre ...',
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                ],
                            ])->label("Semestre");
                        ?>
                        <div id="carga"></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                         <?=
                             $form->field($model, 'mes_periodo')->widget(Select2::classname(), [
                                'data' => [1 => "Mes 1",2 => "Mes 2",3 => "Mes 3",4 => "Mes 4",5 => "Mes 5",6 => "Mes 6"],
                                'options' => [
                                    'placeholder' => 'Seleccione Meses ...',
                                    'multiple' => true
                                ],
                                'pluginOptions' => [
                                    'allowClear' => true,
                                    'tokenSeparators' => [',', ' '],
                                ],
                            ])->label("Meses del Semestre");
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'clave')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
           
             <div class="row">
                <div class="col-xs-12">
                    <div class="col-sm-4">
                        <?= $form->field($model, 'total_creditos')->textInput(['maxlength' => true]) ?>
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

