<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Biblioteca Digital';
$this->params['breadcrumbs'][] = $this->title;


$this->registerJs('
    function leerLibro(ruta){
        $("#lectura").html(\'<center><embed src="'.\Yii::getAlias('@web').'\'+ruta+\'" width="500" height="500"></center>\');
        $("#myModal").modal("show");

    }
', View::POS_END);

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-3"></div>
                <div class="col-sm-6">
                    <form action="#" method="get" class="sidebar-form">
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Buscar Libro...">
                            <span class="input-group-btn">
                                <button type="submit"  id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-2"></div>
                <div class="col-sm-8">
                <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_libro',

                    ]);
                ?>
                </div>
                <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Lectura de Libro</h4>
      </div>
      <div class="modal-body">
        <div id="lectura"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
      </div>
    </div>

  </div>
</div>
