<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Carreras */

$this->title = 'Crear Carreras';
$this->params['breadcrumbs'][] = ['label' => 'Carreras', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="carreras-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
