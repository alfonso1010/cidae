<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Docentes';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <p align="right">
            <?= Html::a('Crear Docente', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
             <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'id_profesor',
                    'cedula',
                    'nombre',
                    'apellido_paterno',
                    'apellido_materno',
                    //'direccion:ntext',
                    'telefono_celular',
                    //'telefono_casa',
                    //'sexo',
                    'email:email',
                    //'fecha_alta',
                    //'activo',
                    //'edad',
                    //'fecha_nacimiento',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
