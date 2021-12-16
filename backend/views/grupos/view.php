<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Carreras;

/* @var $this yii\web\View */
/* @var $model common\models\Grupos */

$this->title = $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="grupos-view">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">
            <p>
                <?= Html::a('Actualizar', ['update', 'id' => $model->id_grupo], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id' => $model->id_grupo], [
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
                    'capacidad',
                    [
                        'attribute' => 'id_carrera',
                        'label' => 'Carrera',
                        'value' => function($model){
                            $carrera = Carreras::findOne(['id_carrera' => $model->id_carrera]);
                            return (!is_null($carrera))?$carrera->nombre:"";
                        }
                    ],
                    'generacion',
                    'modalidad',
                    'no_evaluaciones_periodo',
                    'fecha_alta',
                ],
            ]) ?>
        </div>
    </div>
</div>
