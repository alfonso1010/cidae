<?php

use yii\web\View;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\HorariosProfesorMateria;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ProfesorSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Horarios - Docente';
$this->params['breadcrumbs'][] = $this->title;

function strpos_recursive($haystack, $needle, $offset = 0, &$results = array()) {               
    $offset = strpos($haystack, $needle, $offset);
    if($offset === false) {
        return $results;           
    } else {
        $results[] = $offset;
        return strpos_recursive($haystack, $needle, ($offset + 1), $results);
    }
}

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
            <div class="col-12">
                
                <?php
                    $horario_escolarizado = false;
                    $horario_sabatino = false;
                    foreach ($grupos as $key => $grupo) {
                        $busca_dias_horario = HorariosProfesorMateria::find()
                            ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                            ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                            ->where([
                                'horarios_profesor_materia.id_profesor' => $id_profesor,
                                'horarios_profesor_materia.semestre' => $grupo['semestre_actual'],
                                'horarios_profesor_materia.bloque' => $grupo['bloque_actual'],
                                'horarios_profesor_materia.id_grupo' => $grupo['id_grupo'],
                            ])
                            ->groupBy(['horarios_profesor_materia.dia_semana'])
                            ->asArray()->all();
                        foreach ($busca_dias_horario as $key => $dias_horario) {
                            if($dias_horario['dia_semana'] == 6){
                                $horario_sabatino = true;
                            }else{
                                $horario_escolarizado = true;
                            }
                        }
                    }
                    if(!$horario_escolarizado && !$horario_sabatino){
                        echo "<h4 style='color: brown'> No cuenta con materias asignadas para el semestre y bloque actual. </h4>";
                    }
                    $tabla = "";
                    if($horario_escolarizado){
                        $tabla .= '<div class="table-responsive">
                        <table class="table">
                            <tbody>
                                <tr>
                                    <th style="border:1px solid #252525;">Hora</th>
                                    <th style="border:1px solid #252525;">Lunes</th>
                                    <th style="border:1px solid #252525;">Martes</th>
                                    <th style="border:1px solid #252525;">Miércoles</th>
                                    <th style="border:1px solid #252525;">Jueves</th>
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
                            $sin_clases = true;
                            foreach ($grupos as $key => $grupo) {
                                $busca_horario = HorariosProfesorMateria::find()
                                ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                ->where([
                                    'horarios_profesor_materia.dia_semana' => 1,
                                    'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                    'horarios_profesor_materia.hora_fin' => $hora_fin,
                                    'horarios_profesor_materia.id_profesor' => $id_profesor,
                                    'horarios_profesor_materia.semestre' => $grupo['semestre_actual'],
                                    'horarios_profesor_materia.bloque' => $grupo['bloque_actual'],
                                    'horarios_profesor_materia.id_grupo' => $grupo['id_grupo'],
                                ])->asArray()->all();
                                if(!empty($busca_horario)){
                                    $sin_clases = false;
                                    foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                        <p>
                                            <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                                        </p>
                                        <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                        </p>
                                        </div>';
                                    }
                                }
                            }
                            $tabla .= ($sin_clases)?"RECESO":"";
                            $tabla .= "
                            </td>
                            <td style='white-space: nowrap;border:1px solid #252525;'>";
                            $sin_clases = true;
                            foreach ($grupos as $key => $grupo) {
                                $busca_horario = HorariosProfesorMateria::find()
                                ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                ->where([
                                    'horarios_profesor_materia.dia_semana' => 2,
                                    'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                    'horarios_profesor_materia.hora_fin' => $hora_fin,
                                    'horarios_profesor_materia.id_profesor' => $id_profesor,
                                    'horarios_profesor_materia.semestre' => $grupo['semestre_actual'],
                                    'horarios_profesor_materia.bloque' => $grupo['bloque_actual'],
                                    'horarios_profesor_materia.id_grupo' => $grupo['id_grupo'],
                                ])->asArray()->all();
                                if(!empty($busca_horario)){
                                    $sin_clases = false;
                                    foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                        <p>
                                            <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                                        </p>
                                        <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                        </p>
                                        </div>';
                                    }
                                }
                            }
                            $tabla .= ($sin_clases)?"RECESO":"";
                            $tabla .= "
                            </td>
                            <td style='white-space: nowrap;border:1px solid #252525;'>";
                            $sin_clases = true;
                            foreach ($grupos as $key => $grupo) {
                                $busca_horario = HorariosProfesorMateria::find()
                                ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                ->where([
                                    'horarios_profesor_materia.dia_semana' => 3,
                                    'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                    'horarios_profesor_materia.hora_fin' => $hora_fin,
                                    'horarios_profesor_materia.id_profesor' => $id_profesor,
                                    'horarios_profesor_materia.semestre' => $grupo['semestre_actual'],
                                    'horarios_profesor_materia.bloque' => $grupo['bloque_actual'],
                                    'horarios_profesor_materia.id_grupo' => $grupo['id_grupo'],
                                ])->asArray()->all();
                                if(!empty($busca_horario)){
                                    $sin_clases = false;
                                    foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                        <p>
                                            <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                                        </p>
                                        <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                        </p>
                                        </div>';
                                    }
                                }
                            }
                            $tabla .= ($sin_clases)?"RECESO":"";
                            $tabla .= "
                            </td>
                            <td style='white-space: nowrap;border:1px solid #252525;'>";
                            $sin_clases = true;
                            foreach ($grupos as $key => $grupo) {
                                $busca_horario = HorariosProfesorMateria::find()
                                ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                ->where([
                                    'horarios_profesor_materia.dia_semana' => 4,
                                    'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                    'horarios_profesor_materia.hora_fin' => $hora_fin,
                                    'horarios_profesor_materia.id_profesor' => $id_profesor,
                                    'horarios_profesor_materia.semestre' => $grupo['semestre_actual'],
                                    'horarios_profesor_materia.bloque' => $grupo['bloque_actual'],
                                    'horarios_profesor_materia.id_grupo' => $grupo['id_grupo'],
                                ])->asArray()->all();
                                if(!empty($busca_horario)){
                                    $sin_clases = false;
                                    foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                        <p>
                                            <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                                        </p>
                                        <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                        </p>
                                        </div>';
                                    }
                                }
                            }
                            $tabla .= ($sin_clases)?"RECESO":"";
                            $tabla .= "
                            </td>
                        </tr>";   
                            $hora_inicio = $hora_fin;                  
                        }
                          
                        $tabla .= "
                            </tbody>
                        </table></div>";
                        $tabla .= "<br>";
                        $tabla .= '<table class="table">
                            <tbody>
                                <tr>
                                    <th style="border:1px solid #252525;">Hora</th>
                                    <th style="border:1px solid #252525;">Viernes</th>
                                </tr>';
                        $hora_inicio = "07:00"; 
                        for ($i=1; $i < 6; $i++) {
                            if($i == 3){
                                $suma_hora = strtotime ( '+30 minute' , strtotime ($hora_inicio) ) ;
                            }else{
                                $suma_hora = strtotime ( '+1 hour' , strtotime ($hora_inicio) ) ; 
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
                            $sin_clases = true;
                            foreach ($grupos as $key => $grupo) {
                                $busca_horario = HorariosProfesorMateria::find()
                                ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                ->where([
                                    'horarios_profesor_materia.dia_semana' => 5,
                                    'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                    'horarios_profesor_materia.hora_fin' => $hora_fin,
                                    'horarios_profesor_materia.id_profesor' => $id_profesor,
                                    'horarios_profesor_materia.semestre' => $grupo['semestre_actual'],
                                    'horarios_profesor_materia.bloque' => $grupo['bloque_actual'],
                                    'horarios_profesor_materia.id_grupo' => $grupo['id_grupo'],
                                ])->asArray()->all();
                                if(!empty($busca_horario)){
                                    $sin_clases = false;
                                    foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                        <p>
                                            <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                                        </p>
                                        <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                        </p>
                                        </div>';
                                    }
                                }
                            }
                            $tabla .= ($sin_clases)?"RECESO":"";
                            $tabla .= "
                            </td>
                        </tr>";   
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
                            $sin_clases = true;
                            foreach ($grupos as $key => $grupo) {
                                $busca_horario = HorariosProfesorMateria::find()
                                ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                                ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                                ->where([
                                    'horarios_profesor_materia.dia_semana' => 6,
                                    'horarios_profesor_materia.hora_inicio' => $hora_inicio,
                                    'horarios_profesor_materia.hora_fin' => $hora_fin,
                                    'horarios_profesor_materia.id_profesor' => $id_profesor,
                                    'horarios_profesor_materia.semestre' => $grupo['semestre_actual'],
                                    'horarios_profesor_materia.bloque' => $grupo['bloque_actual'],
                                    'horarios_profesor_materia.id_grupo' => $grupo['id_grupo'],
                                ])->asArray()->all();
                                if(!empty($busca_horario)){
                                    $sin_clases = false;
                                    foreach ($busca_horario as $key => $horario) {
                                        $tabla .= '
                                        <div style="margin:7px;width: min-contentmargin:7px;;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                                        <p>
                                            <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                                        </p>
                                        <p>
                                            <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                                        </p>
                                        </div>';
                                    }
                                }
                            }
                            $tabla .= ($sin_clases)?"RECESO":"";
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
