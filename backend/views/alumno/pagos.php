<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\Profesor;
use common\models\ProfesorMateria;
use common\models\Materias;
use common\models\HorariosProfesorMateria;
use common\models\Carreras;
use common\models\Grupos;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Pagos Alumno';
$this->params['breadcrumbs'][] = $this->title;

$dia = Yii::$app->formatter->asDate('now', 'php:d');
$habilita_registro_pago = false;
if($dia < 6){
  $habilita_registro_pago = true;
}

$this->registerJs('
    
   

', View::POS_END);
$form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); 
?>

<?php
if($habilita_registro_pago){
?>
<div class="box box-primary">
  <div class="box-body">
    
    <div class="row">
      <div class="col-xs-12">
        <div class="col-sm-11">
          <h4><b style="color: #092f87">Registrar Pago</b></h4><br>
          <?php 
            echo $form->errorSummary($modelPagos);
          ?>
        </div>
      </div>
    </div> 
     <div class="row">
        <div class="col-xs-12">
          <div class="col-sm-4">
               <?= $form->field($modelPagos, 'tipo_pago')->widget(Select2::classname(), [
                  'data' => [0 => "Incripción", 1=> "Reinscripción"],
                  'options' => ['placeholder' => 'Seleccione Tipo Pago'],
                  'pluginOptions' => [
                      'allowClear' => true
                  ],
              ])->label("Tipo de Pago") ?>
          </div>
          <div class="col-sm-4">
            <label class="control-label">Fecha Pago</label>
            <?php
                echo DatePicker::widget([
                    'model'=>$modelPagos,
                    'attribute'=>'fecha_pago',
                    'type' => DatePicker::TYPE_INPUT,
                    'options' => [
                        'placeholder' => 'Fecha Pago',
                        'required' => true,
                        'value' => date("Y-m-d")
                    ],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd',
                    ],
                ]);
            ?>
          </div>
          <div class="col-sm-4">
              <?= $form->field($modelPagos, 'monto_pago')->textInput(['maxlength' => true]) ?>
          </div>
        </div>
    </div>
    <div class="row">
      <div class="col-xs-12">
        <div class="col-sm-4">
            <?= $form->field($modelPagos, 'concepto_pago')->textInput(['maxlength' => true]) ?>
        </div>
        <div class="col-sm-4">
          <br>
          <?= $form->field($modelPagos, 'file_recibo')->fileInput()->label("Recibo de Pago (Escaneado)"); ?>
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
<?php } ?>
<div class="box box-primary">
  <div class="box-body">
    <div class="row">
        <div class="col-xs-12">
            <div class="col-sm-11">
                <h4><b style="color: #092f87">Control de Pagos</b></h4><br>
                 <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                  'fecha_pago',
                  'monto_pago',
                  'concepto_pago',
                   [
                      'attribute' => 'estatus_pago',
                      'label' => 'Estatus Pago',
                      'format' => 'raw',
                      'value' => function($model){
                        switch ($model['estatus_pago']) {
                          case '0':
                            return "<p style='color:blue'>Pendiente Revisión</p>";
                            break;
                          case '1':
                            return "<p style='color:green'>Aprobado</p>";
                            break;
                          case '2':
                            return "<p style='color:red'>Declinado</p>";
                            break;
                        }
                      }
                    ],
                ],
            ]); ?>
            </div>
        </div>
    </div>
  </div>
</div>