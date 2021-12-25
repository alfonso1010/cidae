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
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
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
        $grupos = Grupos::find()->select(["id_grupo",'nombre'])->where(['id_carrera' => $id,'activo' => 0])->all();
        echo "<option value=''>Seleccione Grupo ...</option>";
        if(!empty($grupos)){
            foreach ($grupos as $key => $grupo) {
                echo "<option value='".$grupo->id_grupo."'>".$grupo->nombre."</option>";
            }
        }else{
            echo "<option value=''> No hay grupos ...</option>";
        }
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
        if($id_carrera > 0 && $id_grupo > 0 && $semestre > 0){
            $profesores = Materias::find()->select(["profesor.id_profesor",'concat(profesor.nombre, " ", profesor.apellido_paterno, " ", profesor.apellido_materno) as nombre_completo',"materias.nombre as nombre_materia","materias.id_materia"])
                ->innerJoin( 'profesor_materia','materias.id_materia = profesor_materia.id_materia')
                ->innerJoin( 'profesor','profesor_materia.id_profesor = profesor.id_profesor')
                ->where(["materias.id_carrera" => $id_carrera])
                ->asArray()->all();
            if(!empty($profesores)){
                $select_prof = "
                    <option value='0'> Seleccione </option>
                    <option value='libre'> Hora Libre </option>
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
                            <th>Viernes</th>
                            <th>Sábado</th>
                        </tr>';
                    for ($i=8; $i < 20; $i++) {
                        $hora_fin = $i+1; 
                        $tabla .= "
                        <tr>
                            <td width='120px'> 
                                <b style='color: #092f87' >".$i.":00 - ".$hora_fin.":00</b>
                            </td>
                            <td>
                                <select onChange='seleccionados(1,".$i.",".$hora_fin.",this)' class='form-control'>
                                    <option value='0'> Seleccione </option>
                                    ";
                                    $busca_horario_libre = HorariosProfesorMateria::findOne([
                                        'dia_semana' => 1,
                                        'hora_inicio' => $i,
                                        'hora_fin' => $hora_fin,
                                        'id_materia' => 0,
                                        'id_profesor' => 0,
                                        'semestre' => $semestre,
                                        'id_grupo' => $id_grupo,
                                    ]);
                                    if(!is_null($busca_horario_libre)){
                                        $tabla .= "<option selected='true' value='libre'> Hora Libre </option>";
                                    }else{
                                        $tabla .= "<option value='libre'> Hora Libre </option>";
                                    }
                                    foreach ($profesores as $key => $profesor) {
                                        $busca_horario = HorariosProfesorMateria::findOne([
                                            'dia_semana' => 1,
                                            'hora_inicio' => $i,
                                            'hora_fin' => $hora_fin,
                                            'id_materia' => $profesor['id_materia'],
                                            'id_profesor' => $profesor['id_profesor'],
                                            'semestre' => $semestre,
                                            'id_grupo' => $id_grupo,
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
                                    $tabla .= "
                                </select>
                            </td>
                            <td>
                                <select onChange='seleccionados(2,".$i.",".$hora_fin.",this)' class='form-control'>
                                    <option value='0'> Seleccione </option>
                                    ";
                                    $busca_horario_libre = HorariosProfesorMateria::findOne([
                                        'dia_semana' => 2,
                                        'hora_inicio' => $i,
                                        'hora_fin' => $hora_fin,
                                        'id_materia' => 0,
                                        'id_profesor' => 0,
                                        'semestre' => $semestre,
                                        'id_grupo' => $id_grupo,
                                    ]);
                                    if(!is_null($busca_horario_libre)){
                                        $tabla .= "<option selected='true' value='libre'> Hora Libre </option>";
                                    }else{
                                        $tabla .= "<option value='libre'> Hora Libre </option>";
                                    }
                                    foreach ($profesores as $key => $profesor) {
                                         $busca_horario = HorariosProfesorMateria::findOne([
                                            'dia_semana' => 2,
                                            'hora_inicio' => $i,
                                            'hora_fin' => $hora_fin,
                                            'id_materia' => $profesor['id_materia'],
                                            'id_profesor' => $profesor['id_profesor'],
                                            'semestre' => $semestre,
                                            'id_grupo' => $id_grupo,
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
                                    $tabla .= "
                                </select>
                            </td>
                            <td>
                                <select onChange='seleccionados(3,".$i.",".$hora_fin.",this)'  class='form-control'>
                                    <option value='0'> Seleccione </option>
                                    ";
                                    $busca_horario_libre = HorariosProfesorMateria::findOne([
                                        'dia_semana' => 3,
                                        'hora_inicio' => $i,
                                        'hora_fin' => $hora_fin,
                                        'id_materia' => 0,
                                        'id_profesor' => 0,
                                        'semestre' => $semestre,
                                        'id_grupo' => $id_grupo,
                                    ]);
                                    if(!is_null($busca_horario_libre)){
                                        $tabla .= "<option selected='true' value='libre'> Hora Libre </option>";
                                    }else{
                                        $tabla .= "<option value='libre'> Hora Libre </option>";
                                    }
                                    foreach ($profesores as $key => $profesor) {
                                         $busca_horario = HorariosProfesorMateria::findOne([
                                            'dia_semana' => 3,
                                            'hora_inicio' => $i,
                                            'hora_fin' => $hora_fin,
                                            'id_materia' => $profesor['id_materia'],
                                            'id_profesor' => $profesor['id_profesor'],
                                            'semestre' => $semestre,
                                            'id_grupo' => $id_grupo,
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
                                    $tabla .= "
                                </select>
                            </td>
                            <td>
                                <select onChange='seleccionados(4,".$i.",".$hora_fin.",this)' class='form-control'>
                                    <option value='0'> Seleccione </option>
                                    ";
                                    $busca_horario_libre = HorariosProfesorMateria::findOne([
                                        'dia_semana' => 4,
                                        'hora_inicio' => $i,
                                        'hora_fin' => $hora_fin,
                                        'id_materia' => 0,
                                        'id_profesor' => 0,
                                        'semestre' => $semestre,
                                        'id_grupo' => $id_grupo,
                                    ]);
                                    if(!is_null($busca_horario_libre)){
                                        $tabla .= "<option selected='true' value='libre'> Hora Libre </option>";
                                    }else{
                                        $tabla .= "<option value='libre'> Hora Libre </option>";
                                    }
                                    foreach ($profesores as $key => $profesor) {
                                        $busca_horario = HorariosProfesorMateria::findOne([
                                            'dia_semana' => 4,
                                            'hora_inicio' => $i,
                                            'hora_fin' => $hora_fin,
                                            'id_materia' => $profesor['id_materia'],
                                            'id_profesor' => $profesor['id_profesor'],
                                            'semestre' => $semestre,
                                            'id_grupo' => $id_grupo,
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
                                    $tabla .= "
                                </select>
                            </td>
                            <td>
                                <select onChange='seleccionados(5,".$i.",".$hora_fin.",this)' class='form-control'>
                                    <option value='0'> Seleccione </option>
                                    ";
                                    $busca_horario_libre = HorariosProfesorMateria::findOne([
                                        'dia_semana' => 5,
                                        'hora_inicio' => $i,
                                        'hora_fin' => $hora_fin,
                                        'id_materia' => 0,
                                        'id_profesor' => 0,
                                        'semestre' => $semestre,
                                        'id_grupo' => $id_grupo,
                                    ]);
                                    if(!is_null($busca_horario_libre)){
                                        $tabla .= "<option selected='true' value='libre'> Hora Libre </option>";
                                    }else{
                                        $tabla .= "<option value='libre'> Hora Libre </option>";
                                    }
                                    foreach ($profesores as $key => $profesor) {
                                        $busca_horario = HorariosProfesorMateria::findOne([
                                            'dia_semana' => 5,
                                            'hora_inicio' => $i,
                                            'hora_fin' => $hora_fin,
                                            'id_materia' => $profesor['id_materia'],
                                            'id_profesor' => $profesor['id_profesor'],
                                            'semestre' => $semestre,
                                            'id_grupo' => $id_grupo,
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
                                    $tabla .= "
                                </select>
                            </td>
                            <td>
                                <select onChange='seleccionados(6,".$i.",".$hora_fin.",this)' class='form-control'>
                                    <option value='0'> Seleccione </option>
                                    ";
                                    $busca_horario_libre = HorariosProfesorMateria::findOne([
                                        'dia_semana' => 6,
                                        'hora_inicio' => $i,
                                        'hora_fin' => $hora_fin,
                                        'id_materia' => 0,
                                        'id_profesor' => 0,
                                        'semestre' => $semestre,
                                        'id_grupo' => $id_grupo,
                                    ]);
                                    if(!is_null($busca_horario_libre)){
                                        $tabla .= "<option selected='true' value='libre'> Hora Libre </option>";
                                    }else{
                                        $tabla .= "<option value='libre'> Hora Libre </option>";
                                    }
                                    foreach ($profesores as $key => $profesor) {
                                         $busca_horario = HorariosProfesorMateria::findOne([
                                            'dia_semana' => 6,
                                            'hora_inicio' => $i,
                                            'hora_fin' => $hora_fin,
                                            'id_materia' => $profesor['id_materia'],
                                            'id_profesor' => $profesor['id_profesor'],
                                            'semestre' => $semestre,
                                            'id_grupo' => $id_grupo,
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
                                    $tabla .= "
                                </select>
                            </td>
                          
                        </tr>
                        ";                    
                    }
                    
                $tabla .= "
                    </tbody>
                </table>";
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
        if($id_carrera > 0 && $id_grupo > 0 && $semestre > 0){
            //print_r($horarios);die();
            foreach ($horarios as $key => $horario) {
                if($horario['eliminar'] == 1){
                    $busca_horario = HorariosProfesorMateria::findOne([
                        'dia_semana' => $horario['dia'],
                        'hora_inicio' => $horario['hora_inicio'],
                        'hora_fin' => $horario['hora_fin'],
                        'semestre' => $semestre,
                        'id_grupo' => $id_grupo,
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

   
}
