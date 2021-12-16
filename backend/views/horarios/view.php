<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Horarios */

$this->title = $model->id_horario;
$this->params['breadcrumbs'][] = ['label' => 'Horarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="horarios-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_horario' => $model->id_horario, 'id_grupo' => $model->id_grupo], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_horario' => $model->id_horario, 'id_grupo' => $model->id_grupo], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Está seguro de eliminar este registro?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_horario',
            'id_grupo',
            'turno',
        ],
    ]) ?>

</div>
