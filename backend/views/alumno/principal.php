<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\Profesor;
use common\models\ProfesorMateria;
use common\models\Materias;
use common\models\HorariosProfesorMateria;
use common\models\Carreras;
use common\models\Grupos;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horario - Alumno';
$this->params['breadcrumbs'][] = $this->title;

$url =Url::to(['profesores/cargahorario']);

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
                    <h4><b style="color: #092f87">Horario</b></h4><br>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="col-sm-11">
                    <?php
                    $busca_dias_horario = HorariosProfesorMateria::find()
                      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
                      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                      ->where([
                        'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                      ])
                      ->groupBy(['horarios_profesor_materia.dia_semana'])
                      ->asArray()->all();
                    $horario_escolarizado = false;
                    $horario_sabatino = false;
                    foreach ($busca_dias_horario as $key => $dias_horario) {
                      if($dias_horario['dia_semana'] == 6){
                        $horario_sabatino = true;
                      }else{
                        $horario_escolarizado = true;
                      }
                    }
                    $tabla = "";
                    if($horario_escolarizado){
                      $tabla .= '
                      <table class="table">
                          <tbody>
                              <tr >
                                  <th style="border:1px solid #252525;">Hora</th>
                                  <th style="border:1px solid #252525;">Lunes</th>
                                  <th style="border:1px solid #252525;">Martes</th>
                                  <th style="border:1px solid #252525;">Miércoles</th>
                                  <th style="border:1px solid #252525;">Jueves</th>
                                  <th style="border:1px solid #252525;">Viernes</th>
                              </tr>';
                          $hora_inicio = "07:00"; 
                          for ($i=1; $i < 4; $i++) {
                              if($i == 2){
                                  $suma_hora = strtotime ( '+30 minute' , strtotime ($hora_inicio) ) ;
                              }else{
                                  $suma_hora = strtotime ( '+2 hour' , strtotime ($hora_inicio) ) ; 
                              }
                              $hora_fin = date ('H:i', $suma_hora); 

                              if($i%2 == 0){
                                $tabla .= "<tr style='background-color:white'>";
                              }else{
                                $tabla .= "<tr style='background-color:#c2c2c2'>";
                              }
                              $tabla .= "
                                  <td  style='white-space: nowrap;border:1px solid #252525;'> 
                                      <b style='color: #092f87' >".$hora_inicio." - ".$hora_fin."</b>
                                  </td>
                                  <td style='white-space: nowrap;border:1px solid #252525;'>";
                                    $busca_horario = HorariosProfesorMateria::find()
                                    ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                    ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                    ->where([
                                      'horarios_profesor_materia.dia_semana' => 1,
                                      'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                      'horarios_profesor_materia.hora_fin' => $hora_fin,
                                      'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                                    ])->asArray()->all();
                                    if(!empty($busca_horario)){
                                      foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                          <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                          </p>
                                        </div>';
                                      }
                                    }else{
                                        $tabla .='RECESO'; 
                                    }
                                  $tabla .= "
                                  </td>
                                  <td style='white-space: nowrap;border:1px solid #252525;'>";
                                    $busca_horario = HorariosProfesorMateria::find()
                                    ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                    ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                    ->where([
                                      'horarios_profesor_materia.dia_semana' => 2,
                                      'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                      'horarios_profesor_materia.hora_fin' => $hora_fin,
                                      'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                                    ])->asArray()->all();
                                    if(!empty($busca_horario)){
                                      foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                          <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                          </p>
                                        </div>';
                                      }
                                    }else{
                                        $tabla .='RECESO'; 
                                    }
                                  $tabla .= "
                                  </td>
                                  <td style='white-space: nowrap;border:1px solid #252525;'>";
                                    $busca_horario = HorariosProfesorMateria::find()
                                    ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                    ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                    ->where([
                                      'horarios_profesor_materia.dia_semana' => 3,
                                      'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                      'horarios_profesor_materia.hora_fin' => $hora_fin,
                                      'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                                    ])->asArray()->all();
                                    if(!empty($busca_horario)){
                                      foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                          <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                          </p>
                                        </div>';
                                      }
                                    }else{
                                        $tabla .='RECESO'; 
                                    }
                                  $tabla .= "
                                  </td>
                                  <td style='white-space: nowrap;border:1px solid #252525;'>";
                                    $busca_horario = HorariosProfesorMateria::find()
                                    ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                    ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                    ->where([
                                      'horarios_profesor_materia.dia_semana' => 4,
                                      'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                      'horarios_profesor_materia.hora_fin' => $hora_fin,
                                      'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                                    ])->asArray()->all();
                                    if(!empty($busca_horario)){
                                      foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                          <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                          </p>
                                        </div>';
                                      }
                                    }else{
                                        $tabla .='RECESO'; 
                                    }
                                  $tabla .= "
                                  </td>
                                  <td style='white-space: nowrap;border:1px solid #252525;'>";
                                    $busca_horario = HorariosProfesorMateria::find()
                                    ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                    ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                    ->where([
                                      'horarios_profesor_materia.dia_semana' => 5,
                                      'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                      'horarios_profesor_materia.hora_fin' => $hora_fin,
                                      'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                                    ])->asArray()->all();
                                    if(!empty($busca_horario)){
                                      foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                          <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                          </p>
                                        </div>';
                                      }
                                    }else{
                                        $tabla .='RECESO'; 
                                    }
                                  $tabla .= "
                                  </td>
                              </tr>
                              ";   
                            $hora_inicio = $hora_fin;                  
                          }
                          
                      $tabla .= "
                          </tbody>
                      </table>";
                    }
                    if($horario_sabatino){
                       $tabla .= '<h4> Horario Sabatino </h4>
                      <table class="table">
                          <tbody>
                              <tr >
                                  <th style="border:1px solid #252525;">Hora</th>
                                  <th style="border:1px solid #252525;">Sábado</th>
                              </tr>';
                          $hora_inicio = "08:00"; 
                          for ($i=1; $i < 7; $i++) {
                              if($i == 2 | $i == 5){
                                  $suma_hora = strtotime ( '+30 minute' , strtotime ($hora_inicio) ) ;
                              }else{
                                  $suma_hora = strtotime ( '+2 hour 30 minute' , strtotime ($hora_inicio) ) ; 
                              }
                              $hora_fin = date ('H:i', $suma_hora); 

                              if($i%2 == 0){
                                $tabla .= "<tr style='background-color:white'>";
                              }else{
                                $tabla .= "<tr style='background-color:#c2c2c2'>";
                              }
                              $tabla .= "
                                  <td  style='white-space: nowrap;border:1px solid #252525;'> 
                                      <b style='color: #092f87' >".$hora_inicio." - ".$hora_fin."</b>
                                  </td>
                                  <td style='white-space: nowrap;border:1px solid #252525;'>";
                                    $busca_horario = HorariosProfesorMateria::find()
                                    ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                    ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                    ->where([
                                      'horarios_profesor_materia.dia_semana' => 6,
                                      'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                      'horarios_profesor_materia.hora_fin' => $hora_fin,
                                      'horarios_profesor_materia.id_grupo' => $busca_alumno->id_grupo,
                                    ])->asArray()->all();
                                    if(!empty($busca_horario)){
                                      foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                          <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                          </p>
                                        </div>';
                                      }
                                    }else{
                                        $tabla .='RECESO'; 
                                    }
                                  $tabla .= "
                                  </td>
                              </tr>
                              ";   
                            $hora_inicio = $hora_fin;                  
                          }
                          
                      $tabla .= "
                          </tbody>
                      </table>";
                    }

                    echo $tabla;
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
