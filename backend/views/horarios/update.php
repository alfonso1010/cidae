<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Horarios */

$this->title = 'Update Horarios: ' . $model->id_horario;
$this->params['breadcrumbs'][] = ['label' => 'Horarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_horario, 'url' => ['view', 'id_horario' => $model->id_horario, 'id_grupo' => $model->id_grupo]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="horarios-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
