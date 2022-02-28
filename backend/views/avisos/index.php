<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AvisosSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Avisos';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <p align="right">
            <?= Html::a('Crear Aviso', ['create'], ['class' => 'btn btn-success']) ?>
        </p>
         <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="box-body table-responsive no-padding">
            <?= 
            GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'nombre',
                    [
                      'attribute' => 'estatus',
                      'label' => 'Estatus',
                      'format' => 'raw',
                      'value' => function($model){
                        switch ($model['estatus']) {
                          case '0':
                            return "<p style='color:green'>Activo</p>";
                            break;
                          case '1':
                            return "<p style='color:brown'>Pausado</p>";
                            break;
                        }
                      }
                    ],
                    [
                      'class'    => 'yii\grid\ActionColumn',
                      'header' => 'Acciones',
                      'template' => '{acciones}',
                      'buttons'  => [
                          'acciones' => function ($url, $model) {
                            if($model['estatus'] == 0){
                              return "&nbsp;&nbsp;&nbsp".Html::a('<button class="btn btn-warning" >Pausar</button>',
                                      ['avisos/pausar','id'=>$model['id_aviso']], 
                                      ['data' => ['method' => 'post' ]]
                                  );
                            }else{
                              return "&nbsp;&nbsp;&nbsp".Html::a('<button class="btn btn-success" >Activar</button>',
                                      ['avisos/activar','id'=>$model['id_aviso']], 
                                      ['data' => ['method' => 'post' ]]
                                  );
                            }
                          },
                      ],
                    ],
                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
        </div>
    </div>
</div>
