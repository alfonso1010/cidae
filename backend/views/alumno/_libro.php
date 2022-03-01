<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;



?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title" style="color: brown"><b> Título: <?= Html::encode($model->nombre_libro) ?></b></h3>
    </div>
    <div class="box-body">
    	<div class="row">
            <div class="col-xs-12">
            	<div class="col-sm-6">
            		<div class="row">
			            <div class="col-xs-12">
			            	<div style="font-size: 20px;color: brown;" class="col-sm-4">
			            		Autor:
			            	</div>
			            	<div style="font-size: 20px;" class="col-sm-6">
			            		<?= $model->autor ?>
			            	</div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-xs-12">
			            	<div style="font-size: 20px;color: brown;" class="col-sm-4">
			            		Editorial:
			            	</div>
			            	<div style="font-size: 20px;" class="col-sm-6">
			            		<?= $model->editorial ?>
			            	</div>
			            </div>
			        </div>
			        <div class="row">
			            <div class="col-xs-12">
			            	<div style="font-size: 20px;color: brown;" class="col-sm-4">
			            		Descripción:
			            	</div>
			            	<div style="font-size: 20px;" class="col-sm-6">
			            		<?= $model->descripcion ?>
			            	</div>
			            </div>
			        </div>
			        <br><br><br><br>
			         <div class="row">
			            <div class="col-xs-12">
			            	<div class="col-sm-2"></div>
			            	<div class="col-sm-4">
			            		<center><button  onclick="leerLibro('<?= $model->ruta_libro ?>')"; class="btn btn-success" >Leer Libro</button></center>
			            	</div>
			            	<div class="col-sm-4"></div>
			            </div>
			        </div>
            	</div>
            	<div class="col-sm-6">
            		<?php
            		$ruta = \Yii::getAlias('@web')."/".$model->imagen_portada;
            		$ruta = "http://controlescolar.universidadcidae.com.mx";
                    echo '
                    <div class="col-sm-3">
                        <embed src="'.$ruta.'" width="200" height="300">
                    </div>
                    ';
            		?>	
            	</div>
            </div>
        </div>
    </div>
</div>
