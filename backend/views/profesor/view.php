<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Profesor */

$this->title = $model->nombre." ".$model->apellido_paterno;
$this->params['breadcrumbs'][] = ['label' => 'Profesors', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="profesor-view">
     <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id_profesor], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id_profesor], [
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
                    'id_profesor',
                    'nombre',
                    'apellido_paterno',
                    'apellido_materno',
                    'cedula',
                    'direccion:ntext',
                    'telefono_celular',
                    'telefono_casa',
                    'sexo',
                    'email:email',
                    'fecha_alta',
                    'edad',
                    'fecha_nacimiento',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Documentos Docente:</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <?php
                if(strlen($model->doc_acta_nacimiento) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_acta_nacimiento;
                    echo '
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Acta de Nacimiento </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_curp) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_curp;
                    echo '
                     <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> CURP </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_ine) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_ine;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> INE </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_rfc) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_rfc;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> RFC </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_nss) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_nss;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> NSS </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_cedula) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_cedula;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> CÉDULA </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_titulo) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_titulo;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> TÍTULO </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_curriculum) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_curriculum;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> CV </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                if(strlen($model->doc_comp_domicilio) > 0){
                    $ruta = \Yii::getAlias('@web')."/docs_docentes/".$model->id_profesor."/".$model->doc_comp_domicilio;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Comp. Domicilio </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }

                ?>
            </div>
        </div>
    </div>
</div>
