<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BibliotecaDigital */

$this->title = 'Actualizar Libro: ' . $model->nombre_libro;
$this->params['breadcrumbs'][] = ['label' => 'Biblioteca Digitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_libro, 'url' => ['view', 'id' => $model->id_libro]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="biblioteca-digital-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
