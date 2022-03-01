<?php
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

?>

<div class="box box-primary">
	<div class="box-header with-border">
        <center><h3 class="box-title" style="color: brown"><b> <?= Html::encode($model->nombre) ?></b></h3></center>
    </div>
    <div class="box-body">
    	<div class="row">
            <div class="col-xs-12">
            	<div class="col-sm-12">
            		<center>
            		<?php
            		$ruta = \Yii::getAlias('@web')."/".$model->ruta_aviso;
                    echo '
                        <embed src="'.$ruta.'" width="500" height="500">
                    ';
        			?>	
        			</center>
            	</div>
            </div>
        </div>
    </div>
</div>
