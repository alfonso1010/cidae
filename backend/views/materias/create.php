<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Materias */

$this->title = 'Crear Materias';
$this->params['breadcrumbs'][] = ['label' => 'Materias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="materias-create">


    <?= $this->render('_form', [
        'model' => $model,
        'carreras' => $carreras
    ]) ?>

</div>
