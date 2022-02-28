<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ListView;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Avisos';
$this->params['breadcrumbs'][] = $this->title;


$this->registerJs('

', View::POS_END);

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                 <div class="col-sm-2"></div>
                <div class="col-sm-8">
                <?php
                    echo ListView::widget([
                        'dataProvider' => $dataProvider,
                        'itemView' => '_aviso',
                        'viewParams' => [
                            'fullView' => true,
                            'context' => 'main-page',
                            // ...
                        ],
                    ]);
                ?>
                </div>
                 <div class="col-sm-2"></div>
            </div>
        </div>
    </div>
</div>
