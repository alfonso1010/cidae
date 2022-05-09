<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CarrerasSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Formatos Docentes';
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

                    'id',
                    'nombre',
                    [
                        'attribute' => "formato",
                        'format' => 'html',
                        'value' => function($model){
                            $ruta = "https://controlescolar.universidadcidae.com.mx";
                            return "<a href='".$ruta.$model->formato."'>Descargar</a>";
                        }
                    ],
                    'fecha_alta'
                ],
            ]); ?>
        </div>
    </div>
</div>

