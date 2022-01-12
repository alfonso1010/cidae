<?php

namespace backend\controllers;

use Yii;
use common\models\Profesor;
use common\models\ProfesorMateria;
use common\models\Materias;
use common\models\AsistenciaAlumno;
use common\models\HorariosProfesorMateria;
use common\models\Carreras;
use common\models\Alumnos;
use common\models\Grupos;
use common\models\HorariosProfesorMateriaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/**
 * ProfesoresController implements the CRUD actions for Profesor model.
 */
class ProfesoresController extends Controller
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
     * Vista del rol profesor.
     * @return mixed
     */
    public function actionPrincipal()
    {
      $id_profesor = Yii::$app->user->identity->id_responsable;
      //obtiene los grupos a los que da materias el profesor
      $lista_grupos = HorariosProfesorMateria::find()
        ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
        ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
        ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
        ->groupBy(['horarios_profesor_materia.id_grupo'])->asArray()->all();
      $grupos = "";
      foreach ($lista_grupos as $key => $grupo) {
        $grupos .= $grupo['id_grupo'].",";
      }
      $grupos = trim($grupos,",");
      $generaciones = [];
      if(strlen($grupos) > 0){
        $lista_generaciones = Grupos::find()->where('id_grupo IN ('.$grupos.')')->groupBy(['generacion'])->asArray()->all();
        $generaciones = ArrayHelper::map($lista_generaciones, 'generacion', 'generacion');
      }
      
      return $this->render('principal', [
        'generaciones' => $generaciones
      ]);
    }


    public function actionAsistencia(){
      $id_profesor = Yii::$app->user->identity->id_responsable;
      //obtiene los grupos a los que da materias el profesor
      $lista_grupos = HorariosProfesorMateria::find()
        ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
        ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
        ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
        ->groupBy(['horarios_profesor_materia.id_grupo'])->asArray()->all();

      $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre_grupo');
      
      return $this->render('asistencia', [
        'grupos' => $grupos
      ]);
    }

     /**
     * Vista del rol profesor.
     * @return mixed
     */
    public function actionReporteasistencia()
    {

      $id_profesor = Yii::$app->user->identity->id_responsable;
      //obtiene los grupos a los que da materias el profesor
      $lista_grupos = HorariosProfesorMateria::find()
        ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
        ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
        ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
        ->groupBy(['horarios_profesor_materia.id_grupo'])->asArray()->all();

      $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre_grupo');
      
      return $this->render('asistencia', [
        'grupos' => $grupos
      ]);
    }

    public function actionCargaralumnos(){
      $datos = Yii::$app->request->get();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);

      $id_profesor = Yii::$app->user->identity->id_responsable;
      
      $alumnos = '
      <form action="'.Url::to(['profesores/tomarasistencia']).'" method="post">
        <table class="table">
            <tbody>
                <tr >
                    <th style="border:1px solid #252525;color:#092F87">Nombre Alumno</th>
                    <th style="border:1px solid #252525;color:#092F87">Asistencia</th>
                </tr>';
      $busca_alumnos = Alumnos::findAll(["id_grupo" => $id_grupo]);
      if(!empty($busca_alumnos)){
        foreach ($busca_alumnos as $key => $alumno) {
          $alumnos .= 
          "<tr>
            <td width='35%' style='white-space: nowrap;border:1px solid #252525;'> 
              <b style='color: #252525;' >".$alumno->nombreCompleto."</b>
            </td>
            <td  style='white-space: nowrap;border:1px solid #252525;'> 
               
                <label> <b style='color:green' >Asistió</b> <input type='radio' style='height: 23px;width: 23px;vertical-align: middle;' name='".$alumno->id_alumno."' value='1' checked ></label>&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp
                <label> <b style='color:red' >No Asistió </b> <input type='radio' style='height: 23px;width: 23px;vertical-align: middle;' name='".$alumno->id_alumno."' value='0'> </label>
            </td>
          </tr>
          ";
        }
      }
      $alumnos .= 
          "<tr>
            <td style='background-color:white' colspan='2'> 
              <br><center><button type='button' onclick='guardarAsistencia()' class='btn btn-success'> Guardar Asistencia </button></center>
            </td>
          </tr>
          </tbody>
      </table>
      </form>
      ";
      $data = [
            "code" => 200,
            "alumnos" => $alumnos,
            "mensaje" => "Éxito",
        ];
      return json_encode($data);
    }

    public function actionGuardarasistencia(){
      $datos = Yii::$app->request->post();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);
      $semestre = ArrayHelper::getValue($datos, 'semestre', 0);
      $asistencia = ArrayHelper::getValue($datos, 'asistencia', []);
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $busca_materia = Materias::findOne($id_materia);
      $busca_profesor = Profesor::findOne($id_profesor);
      
      if(!empty($asistencia) && !is_null($busca_materia) && !is_null($busca_profesor) && $semestre > 0  ){
        $busca_asistencia = AsistenciaAlumno::findAll([
          'fecha_asistencia' => Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
          'id_materia' => $id_materia,
          'id_profesor' => $id_profesor,
          'id_grupo' => $id_grupo,
          'semestre' => $semestre
        ]);
        if(!empty($busca_asistencia)){
          $data = [
            "code" => 422,
            "mensaje" => "Error al guardar... Ya ha pasado asistencia a los alumnos de este grupo  el día de hoy .",
          ];
        }else{
          foreach ($asistencia as $key => $value) {
            $guarda_asistencia = new AsistenciaAlumno();
            $guarda_asistencia->asistio = $value['asistio'];
            $guarda_asistencia->fecha_asistencia = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
            $guarda_asistencia->hora_asistencia = Yii::$app->formatter->asDate('now', 'php:H:i:s');
            $guarda_asistencia->fecha_alta = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');
            $guarda_asistencia->id_alumno = $value['id_alumno'];
            $guarda_asistencia->id_materia = $id_materia;
            $guarda_asistencia->id_profesor = $id_profesor;
            $guarda_asistencia->id_grupo = $id_grupo;
            $guarda_asistencia->semestre = $semestre;
            $guarda_asistencia->nombre_materia = $busca_materia->nombre;
            $guarda_asistencia->nombre_profesor = $busca_profesor->nombreCompleto;
            $guarda_asistencia->save(false);
          }
          $data = [
              "code" => 200,
              "mensaje" => "Éxito",
          ];
        }
      }else{
        $data = [
            "code" => 422,
            "mensaje" => "Ocurrió un error al guardar la asistencia, verifique que grupo, materia y semestre sean válidos.",
        ];
      }
      
      return json_encode($data);
    }

     /**
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionBuscamaterias($id)
    {
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $lista_materias = HorariosProfesorMateria::find()
      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
      ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
      ->andWhere(['horarios_profesor_materia.id_grupo' => $id])
      ->groupBy(['horarios_profesor_materia.id_materia'])->asArray()->all();
      if(!empty($lista_materias)){
          echo "<option value=''> Seleccione Materia ...</option>";
          foreach ($lista_materias as $key => $materia) {
              echo "<option value='".$materia['id_materia']."'>".$materia['nombre_materia']."</option>";
          }
      }else{
          echo "<option value=''> No hay Materias ...</option>";
      }
    }

    public function actionBuscasemestremateria(){
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $datos = Yii::$app->request->get();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);
      $busca_semestre = HorariosProfesorMateria::find()
        ->where([
          'id_profesor' => $id_profesor,
          'id_materia' => $id_materia,
          'id_grupo' => $id_grupo,
        ])
        ->groupBy(['semestre'])->all();
      if(!empty($busca_semestre)){
        echo "<option value=''>Seleccione Semestre ...</option>";
        foreach ($busca_semestre as $key => $value) {
          echo "<option value='".$value->semestre."'> Semestre ".$value->semestre."</option>";
        }
      }else{
        echo "<option value=''> No hay semestres ...</option>";
      }
    }

     /**
     * Vista del rol profesor.
     * @return mixed
     */
    public function actionBuscasemestre($id)
    {
      $semestres_grupo = HorariosProfesorMateria::find()->where(['id_grupo' => $id])->groupBy(['semestre','id_grupo'])->all();
      if(!empty($semestres_grupo)){
        echo "<option value=''>Seleccione Semestre ...</option>";
        foreach ($semestres_grupo as $key => $value) {
          echo "<option value='".$value->semestre."'> Semestre ".$value->semestre."</option>";
        }
      }else{
        echo "<option value=''> No hay semestres ...</option>";
      }
    }

      /**
     * Vista del rol profesor.
     * @return mixed
     */
    public function actionCargahorario()
    {
      $datos = Yii::$app->request->get();
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $semestre = ArrayHelper::getValue($datos, 'semestre', 0);
      $generacion = ArrayHelper::getValue($datos, 'generacion', 0);
      if($semestre > 0){
        $tabla = '
        <table class="table">
            <tbody>
                <tr >
                    <th style="border:1px solid #252525;">Hora</th>
                    <th style="border:1px solid #252525;">Lunes</th>
                    <th style="border:1px solid #252525;">Martes</th>
                    <th style="border:1px solid #252525;">Miércoles</th>
                    <th style="border:1px solid #252525;">Jueves</th>
                    <th style="border:1px solid #252525;">Viernes</th>
                    <th style="border:1px solid #252525;">Sábado</th>
                </tr>';
            for ($i=8; $i < 20; $i++) {
                $hora_fin = $i+1; 

                if($i%2 == 0){
                  $tabla .= "<tr style='background-color:white'>";
                }else{
                  $tabla .= "<tr style='background-color:#c2c2c2'>";
                }
                $tabla .= "<td  style='white-space: nowrap;border:1px solid #252525;'> 
                        <b style='color: #092f87' >".$i.":00 - ".$hora_fin.":00</b>
                    </td>
                    <td style='white-space: nowrap;border:1px solid #252525;'>";
                      $busca_horario = HorariosProfesorMateria::find()
                      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                      ->where([
                        'horarios_profesor_materia.dia_semana' => 1,
                        'horarios_profesor_materia.hora_inicio' => $i,
                        'horarios_profesor_materia.hora_fin' => $hora_fin,
                        'horarios_profesor_materia.id_profesor' => $id_profesor,
                        'horarios_profesor_materia.semestre' => $semestre,
                        'grupos.generacion' => $generacion,
                      ])->asArray()->all();
                      if(!empty($busca_horario)){
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
                      }else{
                          $tabla .='N/A'; 
                      }
                    $tabla .= "
                    </td>
                    <td style='white-space: nowrap;border:1px solid #252525;'>";
                      $busca_horario = HorariosProfesorMateria::find()
                      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                      ->where([
                        'horarios_profesor_materia.dia_semana' => 2,
                        'horarios_profesor_materia.hora_inicio' => $i,
                        'horarios_profesor_materia.hora_fin' => $hora_fin,
                        'horarios_profesor_materia.id_profesor' => $id_profesor,
                        'horarios_profesor_materia.semestre' => $semestre,
                        'grupos.generacion' => $generacion,
                      ])->asArray()->all();
                      if(!empty($busca_horario)){
                        foreach ($busca_horario as $key => $horario) {
                          $tabla .= '
                          <div style="margin:7px;width: min-content;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                            <p>
                              <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                            </p>
                            <p>
                              <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                            </p>
                          </div>';
                        }
                      }else{
                          $tabla .='N/A'; 
                      }
                            $tabla .= "
                    </td>
                    <td style='white-space: nowrap;border:1px solid #252525;'>";
                     $busca_horario = HorariosProfesorMateria::find()
                      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                      ->where([
                        'horarios_profesor_materia.dia_semana' => 3,
                        'horarios_profesor_materia.hora_inicio' => $i,
                        'horarios_profesor_materia.hora_fin' => $hora_fin,
                        'horarios_profesor_materia.id_profesor' => $id_profesor,
                        'horarios_profesor_materia.semestre' => $semestre,
                        'grupos.generacion' => $generacion,
                      ])->asArray()->all();
                      if(!empty($busca_horario)){
                        foreach ($busca_horario as $key => $horario) {
                          $tabla .= '
                          <div style="margin:7px;width: min-content;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                            <p>
                              <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                            </p>
                            <p>
                              <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                            </p>
                          </div>';
                        }
                      }else{
                          $tabla .='N/A'; 
                      }
                            $tabla .= "
                    </td>
                    <td style='white-space: nowrap;border:1px solid #252525;'>";
                      $busca_horario = HorariosProfesorMateria::find()
                      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                      ->where([
                        'horarios_profesor_materia.dia_semana' => 4,
                        'horarios_profesor_materia.hora_inicio' => $i,
                        'horarios_profesor_materia.hora_fin' => $hora_fin,
                        'horarios_profesor_materia.id_profesor' => $id_profesor,
                        'horarios_profesor_materia.semestre' => $semestre,
                        'grupos.generacion' => $generacion,
                      ])->asArray()->all();
                      if(!empty($busca_horario)){
                        foreach ($busca_horario as $key => $horario) {
                          $tabla .= '
                          <div style="margin:7px;width: min-content;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                            <p>
                              <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                            </p>
                            <p>
                              <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                            </p>
                          </div>';
                        }
                      }else{
                          $tabla .='N/A'; 
                      }
                            $tabla .= "
                    </td>
                    <td style='white-space: nowrap;border:1px solid #252525;'>";
                      $busca_horario = HorariosProfesorMateria::find()
                      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                      ->where([
                        'horarios_profesor_materia.dia_semana' => 5,
                        'horarios_profesor_materia.hora_inicio' => $i,
                        'horarios_profesor_materia.hora_fin' => $hora_fin,
                        'horarios_profesor_materia.id_profesor' => $id_profesor,
                        'horarios_profesor_materia.semestre' => $semestre,
                        'grupos.generacion' => $generacion,
                      ])->asArray()->all();
                      if(!empty($busca_horario)){
                        foreach ($busca_horario as $key => $horario) {
                          $tabla .= '
                          <div style="margin:7px;width: min-content;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                            <p>
                              <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                            </p>
                            <p>
                              <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                            </p>
                          </div>';
                        }
                      }else{
                          $tabla .='N/A'; 
                      }
                            $tabla .= "
                    </td>
                    <td style='white-space: nowrap;border:1px solid #252525;'>";
                      $busca_horario = HorariosProfesorMateria::find()
                      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
                      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
                      ->where([
                        'horarios_profesor_materia.dia_semana' => 6,
                        'horarios_profesor_materia.hora_inicio' => $i,
                        'horarios_profesor_materia.hora_fin' => $hora_fin,
                        'horarios_profesor_materia.id_profesor' => $id_profesor,
                        'horarios_profesor_materia.semestre' => $semestre,
                        'grupos.generacion' => $generacion,
                      ])->asArray()->all();
                      if(!empty($busca_horario)){
                        foreach ($busca_horario as $key => $horario) {
                          $tabla .= '
                          <div style="margin:7px;width: min-content;border:1px solid #092F87; border-radius: 10px;box-shadow: 0px 10px 10px -6px black;padding: 5px;">
                            <p>
                              <b style="color:#092f87">Grupo:</b> <b style="color:black">'.$horario['nombre_grupo'].'</b>
                            </p>
                            <p>
                              <b style="color:#092f87">Materia:</b> <b style="color:black">'.$horario['nombre_materia'].'</b>
                            </p>
                          </div>';
                        }
                      }else{
                          $tabla .='N/A'; 
                      }
                            $tabla .= "
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
              "code" => 201,
              "tabla" => ""
          ];
      }
      
      return json_encode($data);
        
    }


     /**
     * Vista del rol profesor.
     * @return mixed
     */
    public function actionGrupos()
    {
      $id_profesor = Yii::$app->user->identity->id_responsable;
      

      $searchModel = new HorariosProfesorMateriaSearch();
      $dataProvider = $searchModel->searchGruposProfesor(Yii::$app->request->queryParams,$id_profesor);

        return $this->render('grupos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

}
