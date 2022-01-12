<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
             <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'nombre_grupo',
                    'nombre_materia',
                    'nombre_profesor',
                    /*[
                        'class'    => 'yii\grid\ActionColumn',
                        'template' => '{asistencia}   {calificaciones}',
                        'buttons'  => [
                            'asistencia' => function ($url, $model) {
                                return "&nbsp;&nbsp;&nbsp".Html::a('<button class="btn btn-success" >Asistencia</button>',
                                        ['profesores/asistencia','id_grupo'=>$model['id_grupo'],'id_materia'=>$model['id_materia']], 
                                        ['data' => ['method' => 'post' ]]
                                    );
                            },
                            'calificaciones' => function ($url, $model) {
                               return "&nbsp;&nbsp;&nbsp".Html::a('<button class="btn btn-success" >Registrar Calificaciones</button>',
                                        ['profesores/calificaciones','id_grupo'=>$model['id_grupo'],'id_materia'=>$model['id_materia']], 
                                        ['data' => ['method' => 'post' ]]
                                    );
                            },
                        ],
                    ],*/
                ],
            ]); ?>
        </div>
    </div>
</div>
