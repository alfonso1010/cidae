<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Materias */

$this->title = 'Actualizar Materias: ' . $model->nombre;
$this->params['breadcrumbs'][] = ['label' => 'Materias', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->nombre, 'url' => ['view', 'id_materia' => $model->id_materia, 'id_carrera' => $model->id_carrera]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="materias-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'carreras' => $carreras
    ]) ?>

</div>
