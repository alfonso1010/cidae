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
$url1 =Url::to(['horarios/guardarhorarios']);

$this->registerJs('
    

    var horarios = [];
    function cargaHorario(){
        horarios = [];
        $("#carga_horario").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
        //se obtienen los maestros disponibles
        var id_carrera = $("#id_carrera").val();
        var id_grupo = $("#id_grupo").val();
        var id_semestre = $("#id_semestre").val();
        var bloque = $("#bloque").val();
        $.ajax({
            type:"POST", 
            async:false,
            url:"'.$url.'",
            data:{"id_grupo": id_grupo,"id_carrera":id_carrera,"semestre":id_semestre,"bloque":bloque},
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                       $("#table_horas").html(data.tabla);
                       $("#boton_guardar").show();
                    }else if(data.code == 422 ){
                        $("#table_horas").html("");
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                             "message":"<h3 style=\'color:red\' ><b>Error..</b></h3><h4>No existen profesores asignados a las materias de la carrera seleccionada</h4>",
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

    function seleccionados(dia,hora_inicio,hora_fin,select){
        var obj_inserta;
        if(select.value == "libre"){
            obj_inserta = {
                "dia": dia,
                "hora_inicio": hora_inicio,
                "hora_fin": hora_fin,
                "id_maestro": 0,
                "id_materia": 0,
                "eliminar":0,
            };
        }else if( select.value == 0 ){
            obj_inserta = {
                "dia": dia,
                "hora_inicio": hora_inicio,
                "hora_fin": hora_fin,
                "id_maestro": 0,
                "id_materia": 0,
                "eliminar":1,
            };
        }else{
            var maestro_materia = select.value.split("-");
            obj_inserta = {
                "dia": dia,
                "hora_inicio": hora_inicio,
                "hora_fin": hora_fin,
                "id_maestro": maestro_materia[0],
                "id_materia": maestro_materia[1],
                "eliminar":0,
            };
        }
        
        if(horarios.length == 0){
            horarios.push(obj_inserta);
        }else{
            var inserta = true
            horarios.forEach(function(obj, index) {
                if(obj.dia == dia && obj.hora_inicio == hora_inicio && obj.hora_fin == hora_fin){
                    inserta = false;
                    if(select.value == "libre"){
                        obj.id_maestro = 0;
                        obj.id_materia = 0;
                        obj.eliminar = 0;
                    }else if( select.value == 0 ){
                        obj.eliminar = 1;
                    }else{
                        var maestro_materia = select.value.split("-");
                        obj.id_maestro = maestro_materia[0];
                        obj.id_materia = maestro_materia[1];
                        obj.eliminar = 0;
                    }
                }
            });
            if(inserta){
                horarios.push(obj_inserta);
            }
        }
        console.log(horarios);
    }

    function guardar(){
        var id_carrera = $("#id_carrera").val();
        var id_grupo = $("#id_grupo").val();
        var id_semestre = $("#id_semestre").val();
        var bloque = $("#bloque").val();
        $.ajax({
            type:"POST", 
            async:false,
            url:"'.$url1.'",
            data:{
                "id_carrera": id_carrera,
                "id_grupo": id_grupo,
                "semestre": id_semestre,
                "bloque": bloque,
                "horarios": horarios
            },
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                            "message":"<h3 style=\'color:green\' ><b>Éxito.</b></h3><h4>El horario se ha guardado correctamente</h4>",
                            "onok": function(){ location.reload();}
                        }).show();
                    }else if(data.code == 422 ){
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                             "message":"<h3 style=\'color:red\' ><b>Lo sentimos..</b></h3><h4>Por favor seleccione carrera, grupo y semestre</h4>",
                        }).show();
                    }
                }catch(e){
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                    }).show();
                }
            },
            error: function(){
                $("#carga_horario").html("");
                alertify.alert()
                .setting({
                    "label":"Cerrar",
                     "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                }).show();
            },
            dataType: "json",
        });
    }

    


', View::POS_END);

$this->registerCss("
    
");


?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-3">
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
                                });
                                $.post( "'.urldecode(Yii::$app->urlManager->createUrl('materias/buscasemestre?id=')).'"+$(this).val(), function( data ) {
                                    $("select#id_semestre").html( data );
                                });
                            '
                        ],
                        'pluginOptions' => [
                        ],
                    ]);
                     ?>
                </div>
                 <div class="col-sm-3">
                    <label>Seleccione Grupo</label>
                    <?= // With a model and without ActiveForm
                    Html::dropDownList('grupos',null,["0" => "Seleccione Grupo"],[
                        "id" => "id_grupo",
                        'class' => "form-control ",
                        'placeholder' => 'Seleccione Grupo ...',
                    ]);
                     ?>
                    <div id="carga_grupos"></div>
                </div>
                <div class="col-sm-3">
                    <label>Seleccione Semestre</label>
                    <?= // With a model and without ActiveForm
                    Html::dropDownList('semestre',null,["0" => "Seleccione Semestre"],[
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
                        'onChange' => "cargaHorario();"
                    ]);
                     ?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary" id="div_horario">
    <div class="box-header with-border">
        <h3 class="box-title">Generar Horario</h3>
    </div>
    <div class="box-body  table-responsive no-padding">
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