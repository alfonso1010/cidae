<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Reporte de Asistencias';
$this->params['breadcrumbs'][] = $this->title;

$url =Url::to(['profesores/verasistencias']);
$url_reportes =Url::to(['reportes/asistencias']);

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

?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="row">
        <div class="col-xs-12">
            <div class="col-sm-3">
                <label>Seleccione Grupo</label>
                <?= // With a model and without ActiveForm
                    Select2::widget([
                    'name' => 'grupo',
                    'id' => 'id_grupo',
                    'data' => $grupos,
                    'value' => $id_grupo,
                    'options' => [
                        'placeholder' => 'Seleccione Grupo ...',
                         'onchange'=>' 
                            window.location = "'.$url_reportes.'"+"?id_grupo="+$("#id_grupo").val()+"&semestre="+$("#id_semestre").val()+"&bloque="+$("#id_bloque").val();
                        ',
                        'value' => $id_grupo
                    ],
                    'pluginOptions' => [
                    ],
                ]);
                 ?>
            </div>
            <div class="col-sm-3">
                <label>Seleccione Semestre</label>
               <?= // With a model and without ActiveForm
                    Select2::widget([
                    'name' => 'semestre',
                    'id' => 'id_semestre',
                    'value' => $semestre,
                    'data' => [
                        0 => "Limpiar Filtro",
                        1 => "Semestre 1",
                        2 => "Semestre 2",
                        3 => "Semestre 3",
                        4 => "Semestre 4",
                        5 => "Semestre 5",
                        6 => "Semestre 6",
                    ],
                    'options' => [
                        'placeholder' => 'Seleccione Semestre ...',
                        'onchange'=>' 
                            window.location = "'.$url_reportes.'"+"?id_grupo="+$("#id_grupo").val()+"&semestre="+$("#id_semestre").val()+"&bloque="+$("#id_bloque").val();
                        '
                    ],
                    'pluginOptions' => [
                    ],
                ]);
                 ?>
            </div>
            <div class="col-sm-3">
                <label>Seleccione Bloque</label>
                <?= // With a model and without ActiveForm
                    Select2::widget([
                    'name' => 'bloque',
                    'id' => 'id_bloque',
                    'value' => $bloque,
                    'data' => [
                        0 => "Limpiar Filtro",
                        1 => "Bloque 1",
                        2 => "Bloque 2",
                    ],
                    'options' => [
                        'placeholder' => 'Seleccione Bloque ...',
                        'onchange'=>' 
                            window.location = "'.$url_reportes.'"+"?id_grupo="+$("#id_grupo").val()+"&semestre="+$("#id_semestre").val()+"&bloque="+$("#id_bloque").val();    
                        '
                    ],
                    'pluginOptions' => [
                    ],
                ]);
                 ?>
            </div>
        </div>
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
                        'template' => '{acciones} ',
                        'buttons'  => [
                            'acciones' => function ($url, $model) {
                                return '<center><button  onclick="cargaHorario('.$model->id_asistencia_alumno.');" class="btn btn-success" >Ver Asistencias</button></center>';
                            },
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
