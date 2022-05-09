<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Materias;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Temarios';
$this->params['breadcrumbs'][] = $this->title;


$ruta = "https://controlescolar.universidadcidae.com.mx";
$this->registerJs('
    
  function verTemario(ruta){
    $("#temario_img").html(\'<center><embed style="width: 100%;max-width: 100%;height:400px;max-height: 100%;" src="'.$ruta.'\'+ruta+\'" ></center>\');
    $("#myModal").modal("show");

  }

', View::POS_END);
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
                    'nombre_materia',
                    [
                      'class'    => 'yii\grid\ActionColumn',
                      'header' => 'Temario',
                      'template' => '{temario}',
                      'buttons'  => [
                          'temario' => function ($url, $model) {
                                $busca_materia = Materias::findOne($model['id_materia']);
                              return '<center><button  onclick=\'verTemario("'.$busca_materia->temario.'")\'; class="btn btn-success" >Ver Temario </button></center>';
                          },
                      ],
                    ],
                ],
            ]); ?>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade"  role="dialog">
  <div class="modal-dialog modal-lg" >

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Temario</h4>
      </div>
      <div class="modal-body" >
        <div id="temario_img"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
