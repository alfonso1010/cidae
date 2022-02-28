<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BibliotecaDigital */

$this->title = 'Create Biblioteca Digital';
$this->params['breadcrumbs'][] = ['label' => 'Biblioteca Digitals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="biblioteca-digital-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
