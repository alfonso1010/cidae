<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CarrerasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Carreras';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <p align="right">
            <?= Html::a('Nueva Carrera', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute' => 'tipo_carrera',
                        'label' => 'Tipo Carrera',
                        'value' => function($model){
                            return ($model->tipo_carrera == 0)?"Licenciatura":"Maestría";
                        }
                    ],
                    'nombre',
                    'clave',
                    'rvoe',
                    [
                        'attribute' => 'total_periodos',
                        'label' => 'Total Semestres',
                    ],
                    //'fecha_alta',
                    //'activo',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>

