<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Materias */

$this->title = $model->id_materia;
$this->params['breadcrumbs'][] = ['label' => 'Materias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="carreras-view">

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
        </div>
        <div class="box-body">

            <p>
                <?= Html::a('Actualizar', ['update', 'id_materia' => $model->id_materia, 'id_carrera' => $model->id_carrera], ['class' => 'btn btn-primary']) ?>
                <?= Html::a('Eliminar', ['delete', 'id_materia' => $model->id_materia, 'id_carrera' => $model->id_carrera], [
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
                    'id_materia',
                    'nombre',
                    'clave',
                    'total_creditos',
                    ["attribute" => 'periodo', "label" => "Semestre"],
                    ["attribute" => 'mes_periodo', "label" => "Mes Semestre"],
                    'id_carrera',
                    'fecha_alta',
                    'activo',
                ],
            ]) ?>
        </div>
    </div>

</div>
