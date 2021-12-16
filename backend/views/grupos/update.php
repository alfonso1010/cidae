<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Grupos */

$this->title = 'Actualizar Materia: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_grupo, 'url' => ['view', 'id' => $model->id_grupo]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="grupos-update">


    <?= $this->render('_form', [
        'model' => $model,
        'carreras' => $carreras
    ]) ?>

</div>
