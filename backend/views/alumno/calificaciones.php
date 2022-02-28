<?php

use yii\web\View;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Profesor;
use common\models\Materias;
use kartik\widgets\Select2;
use yii\helpers\ArrayHelper;
use common\models\CalificacionAlumno;
use common\models\HorariosProfesorMateria;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Calificaciones Alumno';
$this->params['breadcrumbs'][] = $this->title;

$semestre = $semestre_bloque['semestre'];
$bloque = $semestre_bloque['bloque'];


$this->registerCss('
    table tr:hover {
        background:#ced66b;
    }
');

$this->registerJs('

', View::POS_END);

?>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-8">
                    <h4><b style="color: #092f87">Calificaciones del Semestre: <?= $semestre ?> ,Bloque: <?= $bloque ?> </b></h4><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-10">
                    <?php
                    $busca_materias = HorariosProfesorMateria::find()
                    ->select(['horarios_profesor_materia.id_materia','materias.nombre as nombre_materia'])
                    ->innerJoin( 'materias','horarios_profesor_materia.id_materia = materias.id_materia')
                    ->where([
                        'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                        'horarios_profesor_materia.semestre' => $semestre,
                        'horarios_profesor_materia.bloque' => $bloque,
                    ])
                    ->groupBy(['horarios_profesor_materia.id_materia'])
                    ->asArray()->all();
                    $tabla = '
                    <table class="table">
                        <tbody>
                            <tr >
                                <th style="border:1px solid #252525;color:#092F87"><center>Materia</center></th>
                                <th style="border:1px solid #252525;color:#092F87"><center>Cal. Primer Parcial</center></th>
                                <th style="border:1px solid #252525;color:#092F87"><center>Cal. Segundo Parcial</center></th>
                                <th style="border:1px solid #252525;color:#092F87"><center>Promedio</center></th>
                            </tr>';

                    foreach ($busca_materias as $key => $materia) {
                        $busca_primer_calificacion_alumno = CalificacionAlumno::findOne([
                          'id_alumno' => $busca_alumno->id_alumno,
                          'id_grupo' => $busca_alumno->id_grupo,
                          'semestre' => $semestre,
                          'bloque' => $bloque,
                          'no_evaluacion' => 1,
                          'id_materia' => $materia['id_materia'],
                        ]);

                        $busca_segunda_calificacion_alumno = CalificacionAlumno::findOne([
                          'id_alumno' => $busca_alumno->id_alumno,
                          'id_grupo' => $busca_alumno->id_grupo,
                          'semestre' => $semestre,
                          'bloque' => $bloque,
                          'no_evaluacion' => 2,
                          'id_materia' => $materia['id_materia'],
                        ]);
                        $promedio = "-";
                        if(!is_null($busca_primer_calificacion_alumno) && !is_null($busca_segunda_calificacion_alumno)){
                            $promedio = ($busca_primer_calificacion_alumno->calificacion+$busca_segunda_calificacion_alumno->calificacion)/2;
                            $promedio = floor($promedio);
                            $promedio = number_format($promedio, 2, '.', '');
                        }
                        $tabla .= 
                        "<tr>
                            <td  style='border:1px solid #252525;width:200px;'> 
                              <b style='color: #252525;' >".$materia['nombre_materia']."</b>
                            </td>
                            <td  style='border:1px solid #252525;width:50px;'> 
                               <center>".ArrayHelper::getValue($busca_primer_calificacion_alumno, 'calificacion', "-")."</center>
                            </td>
                            <td  style='border:1px solid #252525;width:50px;'> 
                               <center>".ArrayHelper::getValue($busca_segunda_calificacion_alumno, 'calificacion', "-")."</center>
                            </td>
                            <td  style='border:1px solid #252525;width:50px;'> 
                               <center><p> ".$promedio."</p></center>
                            </td>
                        </tr>";
                    }
                    $tabla .= "
                        </tbody>
                    </table>";
                    echo $tabla;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
