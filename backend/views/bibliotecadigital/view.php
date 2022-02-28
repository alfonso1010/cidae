<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\BibliotecaDigital */

$this->title = $model->nombre_libro;
$this->params['breadcrumbs'][] = ['label' => 'Biblioteca Digital', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="biblioteca-digital-view">

   
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id_libro], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id_libro], [
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
                    'nombre_libro',
                    'autor',
                    'editorial',
                    'descripcion:ntext',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Libro Digital:</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <?php
                if(strlen($model->ruta_libro) > 0){
                    $ruta = \Yii::getAlias('@web')."/".$model->ruta_libro;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Libro: </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div><div class="col-sm-2"></div>
                    ';
                }
                if(strlen($model->imagen_portada) > 0){
                    $ruta = \Yii::getAlias('@web')."/".$model->imagen_portada;
                    echo '
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Portada: </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>

</div>
