<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Avisos */

$this->title = 'Actualizar Avisos: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Avisos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_aviso, 'url' => ['view', 'id' => $model->id_aviso]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="avisos-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
