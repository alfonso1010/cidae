<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Profesor;
use common\models\Materias;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\CalificacionAlumno;
use common\models\HorariosProfesorMateria;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificaciones Alumno';
$this->params['breadcrumbs'][] = $this->title;

$semestre = $semestre_bloque['semestre'];
$bloque = $semestre_bloque['bloque'];
$url =Url::to(['alumno/carga-calificaciones']);

$this->registerCss('
    table tr:hover {
        background:#ced66b;
    }
');

$this->registerJs('
    function cargaCalificaciones(){
        
        $("#carga_calif").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
        //se obtienen los maestros disponibles
        var id_grupo = '.$busca_alumno->id_grupo.';
        var id_semestre = $("#id_semestre").val();
        var bloque = $("#bloque").val();
        $.ajax({
            type:"POST", 
            async:false,
            url:"'.$url.'",
            data:{"id_grupo": id_grupo,"semestre":id_semestre,"bloque":bloque},
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                       $("#table_calificacion").html(data.tabla);
                       $("#boton_guardar").show();
                    }else if(data.code == 422 ){
                        $("#table_calificacion").html("");
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                             "message":"<h3 style=\'color:red\' ><b>Error..</b></h3><h4>No existen profesores asignados a las materias de la carrera seleccionada</h4>",
                        }).show();
                    }else{
                        $("#table_calificacion").html("No se encontraron Calificaciones en el semestre y bloque seleccionado");
                    }
                    $("#carga_calif").html("");
                }catch(e){
                    $("#carga_calif").html("");
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                            "onok": function(){ location.reload();}
                    }).show();
                }
            },
            error: function(){
                $("#carga_calif").html("");
                alertify.alert()
                .setting({
                    "label":"Cerrar",
                     "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                        "onok": function(){ location.reload();}
                }).show();
            },
            dataType: "json",
        });
    }
', View::POS_END);

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-8">
                    <h4><b style="color: #092f87">Semestre Actual: <?= $semestre ?> ,Bloque Actual: <?= $bloque ?> </b></h4><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-3">
                        <label>Seleccione Semestre</label>
                    <?= // With a model and without ActiveForm
                    Html::dropDownList('semestre',null,[
                        "0" => "Seleccione Semestre",
                        "1" => "Semestre 1",
                        "2" => "Semestre 2",
                        "3" => "Semestre 3",
                        "4" => "Semestre 4",
                        "5" => "Semestre 5",
                        "6" => "Semestre 6",
                    ],[
                        "id" => "id_semestre",
                        'class' => "form-control ",
                        'placeholder' => 'Seleccione Grupo ...',
                    ]);
                     ?>
                </div>
                <div class="col-sm-3">
                    <label>Seleccione Bloque</label>
                    <?= // With a model and without ActiveForm
                    Html::dropDownList('bloque',null,[
                            "0" => "Seleccione Bloque",
                            "1" => "Bloque 1",
                            "2" => "Bloque 2",
                        ],[
                        "id" => "bloque",
                        'class' => "form-control ",
                        'placeholder' => 'Seleccione Bloque ...',
                        'onChange' => "cargaCalificaciones();"
                    ]);
                     ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary" id="div_horario">
    <div class="box-header with-border">
        <h3 class="box-title">Calificaciones</h3>
    </div>
    <div class="box-body  table-responsive no-padding">
        <div class="row" >
            
                <div id="carga_calif"></div>
                <div class="col-xs-12" id="table_calificacion">
                </div>
        </div>
    </div>
</div>
