<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Alumnos */

$this->title = 'Actualizar Alumnos: ' . $model->id_alumno;
$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_alumno, 'url' => ['view', 'id' => $model->id_alumno]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="alumnos-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'grupos' => $grupos,
    ]) ?>

</div>
