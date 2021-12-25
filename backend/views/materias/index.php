<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Carreras;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\MateriasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Materias';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <p align="right">
            <?= Html::a('Nueva Materia', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
            <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    [
                        'attribute' => 'id_carrera',
                        'value' => function($model){
                            $carrera = Carreras::findOne($model->id_carrera);
                            return (!is_null($carrera))?$carrera->nombre:"";
                        },
                        'filter' => Html::activeDropDownList($searchModel, 'id_carrera', ArrayHelper::map(Carreras::find()->asArray()->all(), 'id_carrera', 'nombre'),['class'=>'form-control','prompt' => 'Seleccione Carrera']),
                    ],
                    'nombre',
                    'clave',
                    'total_creditos',
                    [
                        'attribute' => 'periodo',
                        'label' => "Semestre",
                        'value' => function($model){
                            return "Semestre ".$model->periodo;
                        },
                    ],
                    [
                        'attribute' => 'mes_periodo',
                        'label' => "Mes del Semestre",
                        'value' => function($model){
                            return "Mes ".$model->mes_periodo;
                        },
                    ],
                    //'mes_periodo',
                    //'id_carrera',
                    //'fecha_alta',
                    //'activo',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
    ]); ?>
        </div>
    </div>
</div>
