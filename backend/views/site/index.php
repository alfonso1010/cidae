<?php
use yii\helpers\Url;
/* @var $this yii\web\View */

$this->title = 'Inicio';

$this->registerCss(<<<CSS
  	.btn {
		border: none;
		text-align: center;
		transition: 0.3s;
	}
	.btn:hover {
	  background-color: #092f87;
	  color: white;
	}
CSS

);

?>
<div class="site-index">

    
    <div class="body-content">

        <div class="row">
            <div class="col-xs-2"></div>
            <div class="col-xs-10">
                <h2 class="texto-azul">CIDAE - BIENVENIDO AL SISTEMA DE CONTROL ESCOLAR </h2>
            </div>
        </div>
        <br><br>
        <div class="row">
        	<div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/certificado.png', true)  ?>" width="50%" height="40%" alt="estudiante  icono premium" title="estudiante icono premium"></center>
                    </div><!-- /.box-body -->
                    <div class="box-header">
                        <center><h3 class="box-title ">Administar Carreras</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/grupos.png', true)  ?>" width="50%" height="40%" alt="estudiante  icono premium" title="estudiante icono premium"></center>
                    </div><!-- /.box-body -->
                    <div class="box-header">
                        <center><h3 class="box-title ">Administar Grupos</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/bloc.png', true)  ?>" width="50%" height="40%" alt="docente  icono premium" title="docente icono premium"></center>
                    </div><!-- /.box-body -->
                     <div class="box-header">
                        <center><h3 class="box-title">Administrar Materias</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/estudiante.png', true)  ?>" width="50%" height="40%" alt="estudiante  icono premium" title="estudiante icono premium"></center>
                    </div><!-- /.box-body -->
                    <div class="box-header">
                        <center><h3 class="box-title ">Administar Alumnos</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
            
            
        </div>
        <div class="row">
        	<div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/graduado.png', true)  ?>" width="50%" height="40%" alt="docente  icono premium" title="docente icono premium"></center>
                    </div><!-- /.box-body -->
                     <div class="box-header">
                        <center><h3 class="box-title">Administrar Docentes</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/ensenando.png', true)  ?>" width="50%" height="40%" alt="estudiante  icono premium" title="estudiante icono premium"></center>
                    </div><!-- /.box-body -->
                    <div class="box-header">
                        <center><h3 class="box-title ">Materias de Docentes</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/calendario.png', true)  ?>" width="50%" height="40%" alt="estudiante  icono premium" title="estudiante icono premium"></center>
                    </div><!-- /.box-body -->
                    <div class="box-header">
                        <center><h3 class="box-title ">Administar Horarios</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
            <div class="col-md-3">
                <div class="box box-solid box-primary btn">
                    <div class="box-body">
                        <center><img src="<?= Url::to('@web/images/escritura.png', true)  ?>" width="50%" height="40%" alt="estudiante  icono premium" title="estudiante icono premium"></center>
                    </div><!-- /.box-body -->
                    <div class="box-header">
                        <center><h3 class="box-title ">Calificaciones de Alumnos</h3></center>
                    </div><!-- /.box-header -->
                </div><!-- /.box -->
            </div>
        </div>

    </div>
</div>
