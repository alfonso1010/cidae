<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Grupos */

$this->title = 'Crear Grupos';
$this->params['breadcrumbs'][] = ['label' => 'Grupos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="grupos-create">


    <?= $this->render('_form', [
        'model' => $model,
        'carreras' => $carreras
    ]) ?>

</div>
