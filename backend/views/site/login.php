<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Inicio de sesión';

$fieldOptions1 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-envelope form-control-feedback'></span>"
];

$fieldOptions2 = [
    'options' => ['class' => 'form-group has-feedback'],
    'inputTemplate' => "{input}<span class='glyphicon glyphicon-lock form-control-feedback'></span>"
];
?>

<div class="login-box"  >
    <div class="login-logo" style="border-radius: 5px;font-size: 30px;background-color: white">
        <img src="<?= Url::to('@web/images/logo_cidae.png', true)  ?>"><br>
        <b style="color:#a5b200"> CONTROL </b><b style="color:#252525"> ESCOLAR</b>
    </div>
    <!-- /.login-logo -->
    <div class="login-box-body" style="border:1px solid #092F87; border-radius: 15px;box-shadow: 0px 10px 10px -6px black;">
        <p class="login-box-msg"  style="font-size: 25px;color: #252525">Iniciar<b style="color:#a5b200"> Sesión</b></p>

        <?php $form = ActiveForm::begin(['id' => 'login-form', 'enableClientValidation' => false]); ?>
        <label style="color: #092F87">Email</label>
        <?= $form
            ->field($model, 'username', $fieldOptions1)
            ->label(false)
            ->textInput(['placeholder' => $model->getAttributeLabel('username')]) ?>
        <label  style="color: #092F87">Contraseña</label>
        <?= $form
            ->field($model, 'password', $fieldOptions2)
            ->label(false)
            ->passwordInput(['placeholder' => $model->getAttributeLabel('password')]) ?>

        <div class="row">
            <!-- /.col -->
            <div class="col-xs-4">
                <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary btn-block btn-flat', 'name' => 'login-button']) ?>
            </div>
            <!-- /.col -->
        </div>


        <?php ActiveForm::end(); ?>

    </div>
    <!-- /.login-box-body -->
</div><!-- /.login-box -->
