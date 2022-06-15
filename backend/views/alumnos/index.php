<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Grupos;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AlumnosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Alumnos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <p align="right">
            <?= Html::a('Crear Alumnos', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    
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
                    //'edad',
                    'curp',
                    //'direccion:ntext',
                    //'telefono_casa',
                    'telefono_celular',
                    //'sexo',
                    'email:email',
                    [
                        'attribute' => 'activo',
                        'label' => 'Estatus',
                        'format' => 'html',
                        'value' => function($model){
                            
                            return $model->estatus;
                        }
                    ],
                    'fecha_ingreso',
                    //'fecha_alta',
                    //'activo',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>

