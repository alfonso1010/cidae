<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Grupos;

/* @var $this yii\web\View */
/* @var $model common\models\Alumnos */

$this->title = $model->nombre." ".$model->apellido_paterno;
$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="alumnos-view">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id_alumno], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id_alumno], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => 'Está seguro de eliminar este registro?',
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

              <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        'id_alumno',
                        [
                            'attribute' => 'id_grupo',
                            'label' => 'Grupo',
                            'value' => function($model){
                                $grupo = Grupos::findOne(['id_grupo' => $model->id_grupo]);
                                return (!is_null($grupo))?$grupo->nombre:"";
                            }
                        ],
                        'matricula',
                        'nombre',
                        'apellido_paterno',
                        'apellido_materno',
                        'edad',
                        'direccion:ntext',
                        'sexo',
                        'email:email',
                        'telefono_celular',
                        'telefono_casa',
                        'fecha_nacimiento',
                        'fecha_alta',
                    ],
                ]) ?>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Documentos Alumno:</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <?php
                if(strlen($model->doc_acta_nacimiento) > 0){
                    $ruta = "http://controlescolar.universidadcidae.com.mx/docs_alumnos/".$model->id_alumno."/".$model->doc_acta_nacimiento;
                    echo '
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Acta de Nacimiento </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_curp) > 0){
                    $ruta = "http://controlescolar.universidadcidae.com.mx/docs_alumnos/".$model->id_alumno."/".$model->doc_curp;
                    echo '
                     <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> CURP </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_ine) > 0){
                    $ruta = "http://controlescolar.universidadcidae.com.mx/docs_alumnos/".$model->id_alumno."/".$model->doc_ine;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> INE </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_comp_domicilio) > 0){
                    $ruta = "http://controlescolar.universidadcidae.com.mx/docs_alumnos/".$model->id_alumno."/".$model->doc_comp_domicilio;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Comp. Domicilio </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_certificado_bachillerato) > 0){
                    $ruta = "http://controlescolar.universidadcidae.com.mx/docs_alumnos/".$model->id_alumno."/".$model->doc_certificado_bachillerato;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Cert. Bachillerato </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }

                ?>
            </div>
        </div>
    </div>
</div>
