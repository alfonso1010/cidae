<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Coordinador */

$this->title = 'Crear Coordinador';
$this->params['breadcrumbs'][] = ['label' => 'Coordinador', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="coordinador-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'grupos' => $grupos,
    ]) ?>

</div>
