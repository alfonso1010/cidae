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

$url =Url::to(['profesor/guardarmaterias']);

$this->registerJs('
    
   

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
                    <h4><b style="color: #092f87">Para consultar el horario por favor seleccione grupo y semestre</b></h4><br>
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
                                $.post( "'.urldecode(Yii::$app->urlManager->createUrl('profesor/buscasemestre?id=')).'"+$(this).val(), function( data ) {
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
                    <label>Seleccione Semestre</label>
                    <?= // With a model and without ActiveForm
                    Html::dropDownList('semestre',null,["0" => "Seleccione Semestre"],[
                        "id" => "id_semestre",
                        'class' => "form-control ",
                        'placeholder' => 'Seleccione Grupo ...',
                        'onChange' => "cargaHorario();"
                    ]);
                     ?>
                </div>
            </div>
        </div>
    </div>
</div>
