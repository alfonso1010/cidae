<?php

namespace backend\controllers;

use Yii;
use common\models\HorariosProfesorMateria;
use common\models\Carreras;
use common\models\Grupos;
use common\models\Materias;
use common\models\Profesor;
use common\models\ProfesorMateria;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * HorariosController implements the CRUD actions for Horarios model.
 */
class HorariosController extends Controller
{
  
   /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
      $behaviors = [];

      $behaviors['access'] = [
          'class' => \yii\filters\AccessControl::className(),
          'rules' => [
              \common\helpers\UtilidadesHelper::behaviorRbac()
          ],
      ];
      $behaviors['verbs'] = [
          'class' => VerbFilter::className(),
          'actions' => [
              'delete' => ['POST'],
          ],
      ];

      return $behaviors;
    }


    /**
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $lista_carreras = Carreras::find()->select(["id_carrera",'nombre'])->where(['activo' => 0])->asArray()->all();
        $carreras = ArrayHelper::map($lista_carreras, 'id_carrera', 'nombre');
        return $this->render('horarios', [
            'carreras' => $carreras,
        ]);
    }

     /**
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionBuscagrupos($id)
    {
        $txt_grupos = "":
        $grupos = Grupos::find()->select(["id_grupo",'nombre'])->where(['id_carrera' => $id,'activo' => 0])->all();
        $txt_grupos .= "<option value=''>Seleccione Grupo ...</option>";
        if(!empty($grupos)){
            foreach ($grupos as $key => $grupo) {
                $txt_grupos .= "<option value='".$grupo->id_grupo."'>".$grupo->nombre."</option>";
            }
        }else{
            $txt_grupos .= "<option value=''> No hay grupos ...</option>";
        }
        return $txt_grupos;
    }

    /**
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionCargarhorarios()
    {
           $datos = Yii::$app->request->post();
        $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
        $id_carrera = ArrayHelper::getValue($datos, 'id_carrera', 0);
        $semestre = ArrayHelper::getValue($datos, 'semestre', 0);
        $bloque = ArrayHelper::getValue($datos, 'bloque', 0);
        if($id_carrera > 0 && $id_grupo > 0 && $semestre > 0 && $bloque > 0){
            $profesores = Materias::find()->select(["profesor.id_profesor",'concat(profesor.nombre, " ", profesor.apellido_paterno, " ", profesor.apellido_materno) as nombre_completo',"materias.nombre as nombre_materia","materias.id_materia"])
                ->innerJoin( 'profesor_materia','materias.id_materia = profesor_materia.id_materia')
                ->innerJoin( 'profesor','profesor_materia.id_profesor = profesor.id_profesor')
                ->where(["materias.id_carrera" => $id_carrera])
                ->andWhere(["materias.activo" => 0])
                ->andWhere(["profesor.activo" => 0])
                ->asArray()->all();
            $grupo = Grupos::findOne($id_grupo);
            if(!empty($profesores) && !is_null($grupo) ){
                if($grupo->modalidad == "Escolarizado"){
                    $select_prof = "
                        <option value='0'> Seleccione </option>
                    ";
                    foreach ($profesores as $key => $profesor) {
                        $select_prof .= '
                        <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                            '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                        </option>
                       '; 
                    }
                    $tabla = '
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Hora</th>
                                <th>Lunes</th>
                                <th>Martes</th>
                                <th>Miércoles</th>
                                <th>Jueves</th>
                            </tr>';
                        $hora_inicio = "07:00"; 
                        for ($i=1; $i < 4; $i++) {
                            if($i == 2){
                                $suma_hora = strtotime ( '+30 minute' , strtotime ($hora_inicio) ) ;
                            }else{
                                $suma_hora = strtotime ( '+2 hour' , strtotime ($hora_inicio) ) ; 
                            }
                            $hora_fin = date ('H:i', $suma_hora); 
                            $tabla .= "
                            <tr>
                                <td width='120px'> 
                                    <b style='color: #092f87' >".$hora_inicio." - ".$hora_fin."</b>
                                </td>
                                <td >
                                    <select onChange='seleccionados(1,\"".$hora_inicio."\",\"".$hora_fin."\",this)' class='form-control'>
                                        <option value='0'> Seleccione </option>
                                        ";
                                        if($i == 2){
                                            $tabla .= "<option selected='true' value='libre'> RECESO </option>";
                                        }else{
                                            foreach ($profesores as $key => $profesor) {
                                                $busca_horario = HorariosProfesorMateria::findOne([
                                                    'dia_semana' => 1,
                                                    'hora_inicio' => $hora_inicio,
                                                    'hora_fin' => $hora_fin,
                                                    'id_materia' => $profesor['id_materia'],
                                                    'id_profesor' => $profesor['id_profesor'],
                                                    'semestre' => $semestre,
                                                    'id_grupo' => $id_grupo,
                                                    'bloque' => $bloque,
                                                ]);
                                                if(!is_null($busca_horario)){
                                                    $tabla .='
                                                    <option selected="true" value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }else{
                                                    $tabla .='
                                                    <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }
                                            }
                                        }
                                        $tabla .= "
                                    </select>
                                </td>
                                 <td>
                                    <select onChange='seleccionados(2,\"".$hora_inicio."\",\"".$hora_fin."\",this)' class='form-control'>
                                        <option value='0'> Seleccione </option>
                                        ";
                                        if($i == 2){
                                            $tabla .= "<option selected='true' value='libre'> RECESO </option>";
                                        }else{
                                            foreach ($profesores as $key => $profesor) {
                                                $busca_horario = HorariosProfesorMateria::findOne([
                                                    'dia_semana' => 2,
                                                    'hora_inicio' => $hora_inicio,
                                                    'hora_fin' => $hora_fin,
                                                    'id_materia' => $profesor['id_materia'],
                                                    'id_profesor' => $profesor['id_profesor'],
                                                    'semestre' => $semestre,
                                                    'id_grupo' => $id_grupo,
                                                    'bloque' => $bloque,
                                                ]);
                                                if(!is_null($busca_horario)){
                                                    $tabla .='
                                                    <option selected="true" value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }else{
                                                    $tabla .='
                                                    <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }
                                            }
                                        }
                                        $tabla .= "
                                    </select>
                                </td>
                                 <td>
                                    <select onChange='seleccionados(3,\"".$hora_inicio."\",\"".$hora_fin."\",this)' class='form-control'>
                                        <option value='0'> Seleccione </option>
                                        ";
                                        if($i == 2){
                                            $tabla .= "<option selected='true' value='libre'> RECESO </option>";
                                        }else{
                                            foreach ($profesores as $key => $profesor) {
                                                $busca_horario = HorariosProfesorMateria::findOne([
                                                    'dia_semana' => 3,
                                                    'hora_inicio' => $hora_inicio,
                                                    'hora_fin' => $hora_fin,
                                                    'id_materia' => $profesor['id_materia'],
                                                    'id_profesor' => $profesor['id_profesor'],
                                                    'semestre' => $semestre,
                                                    'id_grupo' => $id_grupo,
                                                    'bloque' => $bloque,
                                                ]);
                                                if(!is_null($busca_horario)){
                                                    $tabla .='
                                                    <option selected="true" value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }else{
                                                    $tabla .='
                                                    <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }
                                            }
                                        }
                                        $tabla .= "
                                    </select>
                                </td>
                                 <td>
                                    <select onChange='seleccionados(4,\"".$hora_inicio."\",\"".$hora_fin."\",this)' class='form-control'>
                                        <option value='0'> Seleccione </option>
                                        ";
                                        if($i == 2){
                                            $tabla .= "<option selected='true' value='libre'> RECESO </option>";
                                        }else{
                                            foreach ($profesores as $key => $profesor) {
                                                $busca_horario = HorariosProfesorMateria::findOne([
                                                    'dia_semana' => 4,
                                                    'hora_inicio' => $hora_inicio,
                                                    'hora_fin' => $hora_fin,
                                                    'id_materia' => $profesor['id_materia'],
                                                    'id_profesor' => $profesor['id_profesor'],
                                                    'semestre' => $semestre,
                                                    'id_grupo' => $id_grupo,
                                                    'bloque' => $bloque,
                                                ]);
                                                if(!is_null($busca_horario)){
                                                    $tabla .='
                                                    <option selected="true" value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }else{
                                                    $tabla .='
                                                    <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }
                                            }
                                        }
                                        $tabla .= "
                                    </select>
                                </td>
                            </tr>
                            ";    
                            $hora_inicio = $hora_fin;                 
                        }
                        
                    $tabla .= "
                        </tbody>
                    </table>";
                    $tabla .= "<br>";
                    $tabla .= '
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Hora</th>
                                <th>Viernes</th>
                            </tr>';
                        $hora_inicio = "07:00"; 
                        for ($i=1; $i < 6; $i++) {
                            if($i == 3){
                                $suma_hora = strtotime ( '+30 minute' , strtotime ($hora_inicio) ) ;
                            }else{
                                $suma_hora = strtotime ( '+1 hour' , strtotime ($hora_inicio) ) ; 
                            }
                            $hora_fin = date ('H:i', $suma_hora); 
                            $tabla .= "
                            <tr>
                                <td width='120px'> 
                                    <b style='color: #092f87' >".$hora_inicio." - ".$hora_fin."</b>
                                </td>
                                <td >
                                    <select onChange='seleccionados(5,\"".$hora_inicio."\",\"".$hora_fin."\",this)' class='form-control'>
                                        <option value='0'> Seleccione </option>
                                        ";
                                        if($i == 3){
                                            $tabla .= "<option selected='true' value='libre'> RECESO </option>";
                                        }else{
                                            foreach ($profesores as $key => $profesor) {
                                                $busca_horario = HorariosProfesorMateria::findOne([
                                                    'dia_semana' => 5,
                                                    'hora_inicio' => $hora_inicio,
                                                    'hora_fin' => $hora_fin,
                                                    'id_materia' => $profesor['id_materia'],
                                                    'id_profesor' => $profesor['id_profesor'],
                                                    'semestre' => $semestre,
                                                    'id_grupo' => $id_grupo,
                                                    'bloque' => $bloque,
                                                ]);
                                                if(!is_null($busca_horario)){
                                                    $tabla .='
                                                    <option selected="true" value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }else{
                                                    $tabla .='
                                                    <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }
                                            }
                                        }
                                        $tabla .= "
                                    </select>
                                </td>
                            </tr>
                            ";    
                            $hora_inicio = $hora_fin;                 
                        }
                        
                    $tabla .= "
                        </tbody>
                    </table>";
                }else if($grupo->modalidad == "Sabatino"){
                     $select_prof = "
                        <option value='0'> Seleccione </option>
                    ";
                    foreach ($profesores as $key => $profesor) {
                        $select_prof .= '
                        <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                            '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                        </option>
                       '; 
                    }
                    $tabla = '
                    <table class="table">
                        <tbody>
                            <tr>
                                <th>Hora</th>
                                <th>Sábado</th>
                            </tr>';
                        $hora_inicio = "08:00"; 
                        for ($i=1; $i < 7; $i++) {
                            if($i == 2 | $i == 5){
                                $suma_hora = strtotime ( '+30 minute' , strtotime ($hora_inicio) ) ;
                            }else{
                                $suma_hora = strtotime ( '+2 hour 30 minute' , strtotime ($hora_inicio) ) ; 
                            }
                            $hora_fin = date ('H:i', $suma_hora); 
                            $tabla .= "
                            <tr>
                                <td width='120px'> 
                                    <b style='color: #092f87' >".$hora_inicio." - ".$hora_fin."</b>
                                </td>
                                <td >
                                    <select onChange='seleccionados(6,\"".$hora_inicio."\",\"".$hora_fin."\",this)' class='form-control'>
                                        <option value='0'> Seleccione </option>
                                        ";
                                        if($i == 2 | $i == 5){
                                            $tabla .= "<option selected='true' value='libre'> RECESO </option>";
                                        }else{
                                            foreach ($profesores as $key => $profesor) {
                                                $busca_horario = HorariosProfesorMateria::findOne([
                                                    'dia_semana' => 6,
                                                    'hora_inicio' => $hora_inicio,
                                                    'hora_fin' => $hora_fin,
                                                    'id_materia' => $profesor['id_materia'],
                                                    'id_profesor' => $profesor['id_profesor'],
                                                    'semestre' => $semestre,
                                                    'id_grupo' => $id_grupo,
                                                    'bloque' => $bloque,
                                                ]);
                                                if(!is_null($busca_horario)){
                                                    $tabla .='
                                                    <option selected="true" value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }else{
                                                    $tabla .='
                                                    <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                                                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                                                    </option>
                                                   '; 
                                                }
                                            }
                                        }
                                        $tabla .= "
                                    </select>
                                </td>
                            </tr>
                            ";    
                            $hora_inicio = $hora_fin;                 
                        }
                        
                    $tabla .= "
                        </tbody>
                    </table>";
                }
                
                $data = [
                    "code" => 200,
                    "tabla" => $tabla,
                    "mensaje" => "Éxito",
                ];
            }else{
                $data = [
                    "code" => 422,
                    "tabla" => "",
                    "mensaje" => "No existen profesores asignados a las materias de la carrera seleccionada",
                ];
            }
        }else{
            $data = [
                "code" => 201,
                "tabla" => ""
            ];
        }
        
        return json_encode($data);
    }

    public function actionGuardarhorarios()
    {
        $datos = Yii::$app->request->post();
        $horarios = ArrayHelper::getValue($datos, 'horarios', []);
        $id_carrera = ArrayHelper::getValue($datos, 'id_carrera', 0);
        $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
        $semestre = ArrayHelper::getValue($datos, 'semestre', 0);
        $bloque = ArrayHelper::getValue($datos, 'bloque', 0);
        if($id_carrera > 0 && $id_grupo > 0 && $semestre > 0 && $bloque > 0 ){
            //print_r($horarios);die();
            foreach ($horarios as $key => $horario) {
                if($horario['eliminar'] == 1){
                    $busca_horario = HorariosProfesorMateria::findOne([
                        'dia_semana' => $horario['dia'],
                        'hora_inicio' => $horario['hora_inicio'],
                        'hora_fin' => $horario['hora_fin'],
                        'semestre' => $semestre,
                        'id_grupo' => $id_grupo,
                        'bloque' => $bloque,
                    ]);
                    if(!is_null($busca_horario)){
                        $busca_horario->delete();
                    }
                }else{
                    $busca_maestro = Profesor::find()->select(['concat(profesor.nombre, " ", profesor.apellido_paterno, " ", profesor.apellido_materno) as nombre_completo'])->where(['id_profesor' => $horario['id_maestro'] ])->asArray()->one();
                    $busca_materia = Materias::findOne($horario['id_materia']);
                    $nombre_profesor = ArrayHelper::getValue($busca_maestro, 'nombre_completo', "SN");
                    $nombre_materia = ArrayHelper::getValue($busca_materia, 'nombre', "SN");
                    $busca_horario = HorariosProfesorMateria::findOne([
                        'dia_semana' => $horario['dia'],
                        'hora_inicio' => $horario['hora_inicio'],
                        'hora_fin' => $horario['hora_fin'],
                        'semestre' => $semestre,
                        'id_grupo' => $id_grupo,
                        'bloque' => $bloque,
                    ]);
                    if(!is_null($busca_horario)){
                        $nuevo_horario = $busca_horario;
                    }else{
                        $nuevo_horario = new HorariosProfesorMateria();
                    }
                    $nuevo_horario->dia_semana  = $horario['dia'];
                    $nuevo_horario->hora_inicio  = $horario['hora_inicio'];
                    $nuevo_horario->hora_fin  = $horario['hora_fin'];
                    $nuevo_horario->id_materia  = $horario['id_materia'];
                    $nuevo_horario->id_profesor  = $horario['id_maestro'];
                    $nuevo_horario->nombre_materia  = $nombre_materia;
                    $nuevo_horario->nombre_profesor  = $nombre_profesor;
                    $nuevo_horario->semestre  = $semestre;
                    $nuevo_horario->bloque  = $bloque;
                    $nuevo_horario->id_grupo  = $id_grupo;
                    $nuevo_horario->save(false);
                }
            }
            $data = [
                "code" => 200,
                "message" => ""
            ];
        }else{
            $data = [
                "code" => 422,
                "message" => "Por favor envie la informacion completa"
            ];
        }
        

        return json_encode($data);
    }

     /**
     * @inheritdoc
     */
    public function diasSemena() {
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado'
        ];
        return $dias;
    }
}
