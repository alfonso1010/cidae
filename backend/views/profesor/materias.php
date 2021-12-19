<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Materias - Docentes';
$this->params['breadcrumbs'][] = $this->title;

$url =Url::to(['profesor/guardarmaterias']);

$this->registerJs('
    
    function guardar(){
        var guardar_asignadas = [];
        var id_profesor = $("#id_profesor").val();
        $("#tabla_asignadas tr").each(function() {
          guardar_asignadas.push(this.id);
        });

        //se guardan materias
        $.ajax({
            type:"POST", 
            async:false,
            url:"'.$url.'",
            data:{"id_profesor": id_profesor, "materias_asignadas": guardar_asignadas },
            success:function(data){ 
                console.log(data);
                try{
                    if(data.code == 200 ){
                        alertify.alert()
                        .setting({
                            "label":"Cerrar",
                            "message":"<h3 style=\'color:green\' ><b>Éxito</b></h3><h3>La información se ha guardado correctamente</h3>",
                            "onok": function(){ location.reload();}
                        }).show();
                    }else{
                         alertify.alert()
                        .setting({
                            "label":"Cerrar",
                            "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Lo sentimos, ha ocurrido un error, por favor inténtelo de nuevo, de ser posible recargue la página</h4>",
                            "onok": function(){ location.reload();}
                        }).show();
                    }
                }catch(e){
                    alertify.alert()
                    .setting({
                        "label":"Cerrar",
                         "message":"<h3 style=\'color:red\' ><b>Error</b></h3><h4>Ocurrió un error con el servidor, por favor inténtelo mas tarde</h4>",
                            "onok": function(){ location.reload();}
                    }).show();
                }
            },
            error: function(){
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

    function eliminaAsignada(id){
        var nombre_materia = $("#"+id).data("nombre");
        $("#"+id).remove();
        $("#fila_disponibles").append(\'<tr id="\'+id+\'" data-nombre="\'+nombre_materia+\'" ><td><center>\'+nombre_materia+\'</center></td><td><button onclick="agregaAsignada(\'+id+\')" type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i></button></td></tr>\');
    }

    function agregaAsignada(id){
        var nombre_materia = $("#"+id).data("nombre");
        $("#"+id).remove();
        $("#fila_asignadas").append(\'<tr id="\'+id+\'" data-nombre="\'+nombre_materia+\'" ><td><center>\'+nombre_materia+\'</center></td><td><button onclick="eliminaAsignada(\'+id+\')" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button></td></tr>\');  
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
                    <label>Seleccione al Profesor</label>
                    <?= // With a model and without ActiveForm
                        Select2::widget([
                        'name' => 'profesor',
                        'id' => 'id_profesor',
                        'data' => $profesores,
                        'options' => [
                            'placeholder' => 'Seleccione Profesor ...',
                            'onchange'=>'
                                $("#carga").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
                                $.post( "'.urldecode(Yii::$app->urlManager->createUrl('profesor/buscarmaterias')).'/"+$(this).val(), function( data ) {
                                        try {
                                            var datos = JSON.parse(data);
                                            var materias_asignadas = datos.materias_asignadas;                                       
                                            var materias_disponibles = datos.materias_disponibles; 
                                            $("#asignadas").html(materias_asignadas);                                     
                                            $("#disponibles").html(materias_disponibles);                                     
                                            $("#boton_guardar").show();                                     
                                        } catch (error) {
                                            console.log("error");
                                        }
                                        
                                        $("#carga").html("");
                                });'
                        ],
                        'pluginOptions' => [
                        ],
                    ]);
                     ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-6">
                    <div id="carga"></div>
                    <div id="asignadas">
                       
                    </div>
                </div>
                <div class="col-sm-6">
                    <div id="carga"></div>
                    <div id="disponibles">
                       
                    </div>
                    
                </div>
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
