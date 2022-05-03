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

$this->title = 'Pagos Alumnos';
$this->params['breadcrumbs'][] = $this->title;

$ruta = "https://controlescolar.universidadcidae.com.mx";
$this->registerJs('
    
  function verComprobante(ruta){
    $("#comp_img").html(\'<center><embed src="'.$ruta.'\'+ruta+\'" width="500" height="500"></center>\');
    $("#myModal").modal("show");

  }

', View::POS_END);
?>


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
                    [
                      'attribute' => 'nombre_alumno',
                      'filter'=>false,
                      'contentOptions' => ['style' => 'width:20%; white-space: normal;'],
                      'value' => function($model){
                        return $model->alumno->nombre.' '.$model->alumno->apellido_paterno.' '.$model->alumno->apellido_materno;
                      }
                    ],
                    [
                      'attribute' => 'matricula',
                      'value' => function($model){
                        return $model->alumno->matricula;
                      }
                    ],
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
                    [
                      'class'    => 'yii\grid\ActionColumn',
                      'header' => 'Comprobante',
                      'template' => '{comprobante}',
                      'buttons'  => [
                          'comprobante' => function ($url, $model) {
                              return '<center><button  onclick=\'verComprobante("'.$model['ruta_recibo'].'")\'; class="btn btn-success" >Ver Comprobante Pago</button></center>';
                          },
                      ],
                    ],
                    [
                      'class'    => 'yii\grid\ActionColumn',
                      'header' => 'Acciones',
                      'template' => '{acciones}',
                      'buttons'  => [
                          'acciones' => function ($url, $model) {
                             return "&nbsp;&nbsp;&nbsp".Html::a('<button class="btn btn-warning" >Aprobar</button>',
                                      ['alumnos/aprobarpago','id'=>$model['id_pago_alumno']], 
                                      ['data' => ['method' => 'post' ]]
                                  )."&nbsp;&nbsp;&nbsp".Html::a('<button class="btn btn-danger" >Declinar</button>',
                                      ['alumnos/declinarpago','id'=>$model['id_pago_alumno']], 
                                      ['data' => ['method' => 'post' ]]
                                  );
                          },
                      ],
                    ]
                  ]
              ]); ?>
            </div>
        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Comprobante de Pago</h4>
      </div>
      <div class="modal-body">
        <div id="comp_img"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
