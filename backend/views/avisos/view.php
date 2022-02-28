<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Avisos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Avisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="avisos-view">
     <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id_aviso], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id_aviso], [
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
                    'nombre',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Imagen Aviso:</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <?php
                if(strlen($model->ruta_aviso) > 0){
                    $ruta = \Yii::getAlias('@web')."/".$model->ruta_aviso;
                    echo '
                    <div class="col-sm-1"></div>
                    <div class="col-sm-3">
                        <center><h4 style="color:brown"> Aviso: </h4></center>
                        <embed src="'.$ruta.'" width="400" height="500">
                    </div><div class="col-sm-2"></div>
                    ';
                }
                ?>
            </div>
        </div>
    </div>
</div>
