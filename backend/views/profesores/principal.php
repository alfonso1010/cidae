<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarios - Docente';
$this->params['breadcrumbs'][] = $this->title;

$url =Url::to(['profesores/cargahorario']);

$this->registerJs('
    
    function cargaHorario(){
        var generacion = $("#generacion").val();
        var semestre = $("#id_semestre").val();
        var bloque = $("#bloque").val();
        $("#carga_horario").html("<div class=\'loading\'><img src=\'https://www.jose-aguilar.com/scripts/jquery/loading/images/loader.gif\' alt=\'loading\' /><br/>Un momento, por favor...</div>");
        $.ajax({
            type:"GET", 
            async:false,
            url:"'.$url.'",
            data:{"semestre": semestre, "generacion": generacion, "bloque":bloque },
            success:function(data){ 
                try{
                    if(data.code == 200 ){
                       $("#table_horas").html(data.tabla);
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
                <div class="col-sm-8">
                    <h4><b style="color: #092f87">Para consultar el horario por favor seleccione Generación y Semestre</b></h4><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-4">
                    <label>Seleccione Generación</label>
                    <?= // With a model and without ActiveForm
                        Select2::widget([
                        'name' => 'generacion',
                        'id' => 'generacion',
                        'data' => $generaciones,
                        'options' => [
                            'placeholder' => 'Seleccione Generación ...',
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
                        'data' => [
                            "0" => "Seleccione Semestre",
                            "1" => "Semestre 1",
                            "2" => "Semestre 2",
                            "3" => "Semestre 3",
                            "4" => "Semestre 4",
                            "5" => "Semestre 5",
                            "6" => "Semestre 6",
                        ],
                        'options' => [
                            'placeholder' => 'Seleccione Semestre ...',
                        ],
                        'pluginOptions' => [
                        ],
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
        <h3 class="box-title"> Horario</h3>
    </div>
    <div class="box-body  table-responsive no-padding">
        <div class="row" >
            
                <div id="carga_horario"></div>
                <div class="col-xs-12" id="table_horas">
                </div>
        </div>
    </div>
</div>