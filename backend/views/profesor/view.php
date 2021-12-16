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
</div>
