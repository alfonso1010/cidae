<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Registro de Calificaciones';
$this->params['breadcrumbs'][] = $this->title;

$url =Url::to(['profesores/cargaralumnoscal']);
$url_guarda =Url::to(['profesores/guardarcalificaciones']);
$url_registra =Url::to(['profesores/registrarcalificaciones']);

$this->registerCss('
    table tr:hover {
        background:#ced66b;
    }
');

$this->registerJs('


    function cargaAlumnos(){
        var id_grupo = $("#id_grupo").val();
        var id_materia = $("#id_materia").val();
        $("#carga_alumnos").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
        $.ajax({
            type:"GET", 
            async:false,
            url:"'.$url.'",
            data:{
                "id_grupo": id_grupo, 
                "id_materia": id_materia,
            },
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                       $("#table_alumnos").html(data.alumnos);
                    }
                    $("#carga_alumnos").html("");
                }catch(e){
                    $("#carga_alumnos").html("");
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                            "onok": function(){ location.reload();}
                    }).show();
                }
            },
            error: function(){
                $("#carga_alumnos").html("");
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

    function guardarCalificacion(){
        var data_envio = [];
        var id_grupo = $("#id_grupo").val();
        var id_materia = $("#id_materia").val();
        $("input").each(function() {
            if($(this).attr("id") != undefined && $(this).prop("disabled") == false){
                data_envio.push({
                    "id_alumno":$(this).attr("id"),
                    "calificacion":$(this).val(),
                });
            }
        });
        $.ajax({
            type:"POST", 
            async:false,
            url:"'.$url_guarda.'",
            data:{
                "id_grupo": id_grupo, 
                "id_materia": id_materia,  
                "calificaciones":data_envio 
            },
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                            "message":"<h3 style=\'color:green\' ><b>Éxito.</b></h3><h4>La calificación de los alumnos, se ha guardado correctamente</h4>",
                            "onok": function(){ location.reload();}
                        }).show();
                    }else if(data.code == 422 ){
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                             "message":"<h3 style=\'color:red\' ><b>Lo sentimos..</b></h3><h4>"+data.mensaje+"</h4>",
                        }).show();
                    }
                }catch(e){
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor contacte al administrador</h4>",
                            "onok": function(){ location.reload();}
                    }).show();
                }
            },
            error: function(){
                alertify.alert()
                .setting({
                    "label":"Cerrar",
                     "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor,por favor contacte al administrador</h4>",
                        "onok": function(){ location.reload();}
                }).show();
            },
            dataType: "json",
        });
        console.log(data_envio);
    }   

    function confirmarRegistro(no_evaluacion){
        alertify.confirm("¿Está Seguro?", "<h3 style=\'color:brown;\'>Una vez que registre las calificaciones ya no podrá modificarlas</h3>", 
        function(){ 
            registrarCalificaciones(no_evaluacion);
        },function(){
            console.log("cancelado");
        }).set({labels:{ok:"Estoy de acuerdo", cancel: "Cancelar"}});;

    }
   
    function registrarCalificaciones(no_evaluacion){
        var id_grupo = $("#id_grupo").val();
        var id_materia = $("#id_materia").val();
       
        $.ajax({
            type:"POST", 
            async:false,
            url:"'.$url_registra.'",
            data:{
                "id_grupo": id_grupo, 
                "id_materia": id_materia,  
                "no_evaluacion":no_evaluacion
            },
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                            "message":"<h3 style=\'color:green\' ><b>Éxito.</b></h3><h4>La calificación de los alumnos, se ha Registrado correctamente</h4>",
                            "onok": function(){ location.reload();}
                        }).show();
                    }else if(data.code == 422 ){
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                             "message":"<h3 style=\'color:red\' ><b>Lo sentimos..</b></h3><h4>"+data.mensaje+"</h4>",
                        }).show();
                    }
                }catch(e){
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor contacte al administrador</h4>",
                            "onok": function(){ location.reload();}
                    }).show();
                }
            },
            error: function(){
                alertify.alert()
                .setting({
                    "label":"Cerrar",
                     "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor,por favor contacte al administrador</h4>",
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
                    <h4><b style="color: #092f87">Para capturar calificaciones seleccione Grupo y materia</b></h4><br>
                </div>
            </div>
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
                        'options' => [
                            'placeholder' => 'Seleccione Grupo ...',
                             'onchange'=>' 
                                $("#carga_materias").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
                                $.post( "'.urldecode(Yii::$app->urlManager->createUrl('profesores/buscamaterias')).'/"+$(this).val(), function( data ) {
                                  $("select#id_materia").html( data );
                                  $("#carga_materias").html("");
                                  $("#table_alumnos").html("");
                                });
                            '
                        ],
                        'pluginOptions' => [
                        ],
                    ]);
                     ?>
                </div>
                <div class="col-sm-3">
                    <label>Seleccione Materia</label>
                    <?= // With a model and without ActiveForm
                    Html::dropDownList('materias',null,["0" => "Seleccione Materia"],[
                        "id" => "id_materia",
                        'class' => "form-control ",
                        'placeholder' => 'Seleccione Materia ...',
                         'onChange' => 'cargaAlumnos();'
                    ]);
                     ?>
                    <div id="carga_materias"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary" id="div_horario">
    <div class="box-header with-border">
        <h3 class="box-title"> Alumnos</h3>
    </div>
    <div class="box-body  table-responsive no-padding">
        <div class="row" >
            
                <div id="carga_alumnos"></div>
                <div class="col-xs-12" id="table_alumnos">
                </div>
        </div>
    </div>
</div>