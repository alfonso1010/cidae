<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarios';
$this->params['breadcrumbs'][] = $this->title;

$url =Url::to(['horarios/cargarhorarios']);

$this->registerJs('
    
    function cargaHorario(id_grupo){
        $("#carga_horario").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
        //se obtienen los maestros disponibles
        var id_carrera = $("#id_carrera").val();
        $.ajax({
            type:"POST", 
            async:false,
            url:"'.$url.'",
            data:{"id_grupo": id_grupo,"id_carrera":id_carrera},
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                       $("#table_horas").html(data.tabla);
                    }else if(data.code == 422 ){
                        $("#table_horas").html("");
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                             "message":"<h3 style=\'color:red\' ><b>Ups..</b></h3><h4>No existen profesores asignados a las materias de la carrera seleccionada</h4>",
                        }).show();
                    }else{
                        $("#table_horas").html("Seleccione Un Grupo");
                    }
                    $("#carga_horario").html("");
                }catch(e){
                    $("#carga_horario").html("");
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                            "onok": function(){ location.reload();}
                    }).show();
                }
            },
            error: function(){
                $("#carga_horario").html("");
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
                <div class="col-sm-4">
                    <label>Seleccione Carrera</label>
                    <?= // With a model and without ActiveForm
                        Select2::widget([
                        'name' => 'carrera',
                        'id' => 'id_carrera',
                        'data' => $carreras,
                        'options' => [
                            'placeholder' => 'Seleccione Carrera ...',
                            'onchange'=>' 
                                $("#carga_grupos").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
                                $.post( "'.urldecode(Yii::$app->urlManager->createUrl('horarios/buscagrupos')).'/"+$(this).val(), function( data ) {
                                  $("select#id_grupo").html( data );
                                  $("#carga_grupos").html("");
                                });'
                        ],
                        'pluginOptions' => [
                        ],
                    ]);
                     ?>
                </div>
                 <div class="col-sm-4">
                    <label>Seleccione Grupo</label>
                    <?= // With a model and without ActiveForm
                    Html::dropDownList('grupos',null,["0" => "Seleccione Grupo"],[
                        "id" => "id_grupo",
                        'class' => "form-control ",
                        'placeholder' => 'Seleccione Grupo ...',
                        'onchange' => "cargaHorario($(this).val());"
                    ]);
                     ?>
                    <div id="carga_grupos"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary" id="div_horario">
    <div class="box-header with-border">
        <h3 class="box-title">Generar Horario</h3>
    </div>
    <div class="box-body">
        <div class="row" >
            <div id="carga_horario"></div>
            <div class="col-xs-12" id="table_horas">
                
            </div>
        </div>
        <div id="boton_guardar" style="display: none;" class="row">
            <div class="col-xs-12">
                <div class="col-sm-5"></div>
                <div class="col-sm-4">
                    <button class="btn btn-success" onclick="guardar();" >Guardar</button>
                </div>
                <div class="col-sm-4"></div>
            </div>
        </div>
    </div>
</div>