<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\BibliotecaDigitalSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Biblioteca Digital';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <p align="right">
            <?= Html::a('Cargar Libro', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id_libro',
                    'categoria',
                    'nombre_libro',
                    'autor',
                    'editorial',
                    //'ruta_libro:ntext',
                    //'descripcion:ntext',
                    //'estatus',
                    //'activo',
                    //'imagen_portada:ntext',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); 
            ?>
        </div>
    </div>
</div>
