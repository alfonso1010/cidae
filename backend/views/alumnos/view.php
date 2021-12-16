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
</div>
