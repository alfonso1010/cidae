<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Carreras */

$this->title = 'Actualizar Carreras: ' . $model->id_carrera;
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_carrera, 'url' => ['view', 'id' => $model->id_carrera]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="carreras-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
