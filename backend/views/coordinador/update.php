<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Coordinador */

$this->title = 'Actualizar Coordinador: ' . $model->matricula;
$this->params['breadcrumbs'][] = ['label' => 'Coordinadores', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->matricula, 'url' => ['view', 'id' => $model->id_coordinador]];
$this->params['breadcrumbs'][] = 'Actualizar';
?>
<div class="coordinador-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'grupos' => $grupos,
    ]) ?>

</div>
