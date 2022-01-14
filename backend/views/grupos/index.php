<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Carreras;

/* @var $this yii\web\View */
/* @var $searchModel common\models\GruposSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Grupos';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <p align="right">
            <?= Html::a('Crear Grupos', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'nombre',
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
                    'capacidad',
                    //'fecha_alta',
                    //'activo',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
