<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte de Asistencias';
$this->params['breadcrumbs'][] = $this->title;

$url =Url::to(['profesores/verasistencias']);

$this->registerJs('
    
    function cargaHorario(id_asistencia_alumno){

        $.ajax({
            type:"GET", 
            async:false,
            url:"'.$url.'",
            data:{"id_asistencia_alumno": id_asistencia_alumno },
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                       $("#table_asistencia").html(data.tabla);
                       $("#myModal").modal("show");
                    }else{
                        $("#table_asistencia").html("");
                    }
                }catch(e){
                    $("#table_asistencia").html("");
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                            //"onok": function(){ location.reload();}
                    }).show();
                }
            },
            error: function(){
                $("#table_asistencia").html("");
                alertify.alert()
                .setting({
                    "label":"Cerrar",
                     "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                        //"onok": function(){ location.reload();}
                }).show();
            },
            dataType: "json",
        });
    }
   

', View::POS_END);

$this->registerCss('
    modal table tr:hover {
        background:#ced66b;
    }
');
function hola(){
    return "hola";
}
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
             <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'fecha_asistencia',
                    'nombre_grupo',
                    'nombre_materia',
                    'nombre_profesor',
                    'semestre',
                    'bloque',
                    [
                        'class'    => 'yii\grid\ActionColumn',
                        'template' => '{acciones}',
                        'buttons'  => [
                            'acciones' => function ($url, $model) {
                                return '<center><button  onclick="cargaHorario('.$model->id_asistencia_alumno.');" class="btn btn-success" >Ver Asistencias</button></center>';
                            }
                        ],
                    ],
                    [
                        'class'    => 'yii\grid\ActionColumn',
                        'header' => "Editar",
                        'template' => '{editar}',
                        'buttons'  => [
                            'editar' => function ($url, $model){
                                $fecha_actual = date("Y-m-d");
                                $fechaInicial = $model->fecha_asistencia; 
                                $fecha_final = $fechaInicial;
                                $MaxDias = 3; 
                                for ($i=0; $i<$MaxDias; $i++){  
                                    //valida si es sabado o domingo
                                    $dia_siguiente = date("N",strtotime($fecha_final."+ 1 days"));
                                    if($dia_siguiente != 6 && $dia_siguiente != 7 ){
                                        $fecha_final = date("Y-m-d",strtotime($fecha_final."+ 1 days"));
                                    }else{
                                        $fecha_final = date("Y-m-d",strtotime($fecha_final."+ 1 days"));
                                        $i--;
                                    }
                                } 
                                if($fecha_actual <= $fecha_final){
                                    return '<center><button  onclick="editaHorario('.$model->id_asistencia_alumno.');" class="btn btn-success" >Editar Asistencia</button></center>';
                                }
                            }
                        ],
                    ],
                ],
            ]); ?>
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
        <h4 class="modal-title">Detalle de Asistencias</h4>
      </div>
      <div class="modal-body">
        <div id="table_asistencia"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
