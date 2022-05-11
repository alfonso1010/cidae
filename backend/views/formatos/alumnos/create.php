<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\FormatoAlumnos */

$this->title = 'Crear Formato Alumnos';
$this->params['breadcrumbs'][] = ['label' => 'Formato Alumnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="formato-alumnos-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
