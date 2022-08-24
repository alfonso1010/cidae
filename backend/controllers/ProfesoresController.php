<?php

namespace backend\controllers;

use Yii;
use common\models\Profesor;
use common\models\ProfesorMateria;
use common\models\Materias;
use common\models\AsistenciaAlumno;
use common\models\CalificacionAlumno;
use common\models\HorariosProfesorMateria;
use common\models\Carreras;
use common\models\Alumnos;
use common\models\FormatoDocentes;
use common\models\FormatoDocentesSearch;
use common\models\Grupos;
use common\models\HorariosProfesorMateriaSearch;
use common\models\AsistenciaAlumnoSearch;
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
     * Lists all FormatoAlumnos models.
     * @return mixed
     */
    public function actionFormatos()
    {
        $searchModel = new FormatoDocentesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('formatos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Vista del rol profesor.
     * @return mixed
     */
    public function actionPrincipal()
    {
      $id_profesor = Yii::$app->user->identity->id_responsable;

      $busca_profesor = Profesor::findOne($id_profesor);
      if(is_null($busca_profesor)){
          Yii::$app->user->logout();
          return $this->goHome();
      }
      //obtiene los grupos a los que da materias el profesor
      $lista_grupos = HorariosProfesorMateria::find()
        ->select(['horarios_profesor_materia.id_grupo','grupos.nombre as nombre_grupo','grupos.generacion'])
        ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
        ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
        ->andWhere(['grupos.activo' => 0])
        ->groupBy([
          'horarios_profesor_materia.id_grupo',
        ])->asArray()->all();
      //print_r($lista_grupos);die();
      $grupos = [];
      foreach ($lista_grupos as $key => $grupo) {
        $busca_grupo = Grupos::findOne($grupo['id_grupo']);
        if(!is_null($busca_grupo)){
          $semestre_bloque = \common\helpers\UtilidadesHelper::calculaSemestreBloque($busca_grupo);
          //print_r($semestre_bloque);die();
          if(!is_null($semestre_bloque)){
            $grupo['semestre_actual'] = $semestre_bloque['semestre'];
            $grupo['bloque_actual'] = $semestre_bloque['bloque'];
            $grupos[] = $grupo;
          }
        }
      }
      //print_r($grupos);die();
      return $this->render('principal', [
        'grupos' => $grupos,
        'id_profesor' => $id_profesor
      ]);
    }


    public function actionAsistencia(){
      $id_profesor = Yii::$app->user->identity->id_responsable;
      //obtiene los grupos a los que da materias el profesor
      $lista_grupos = HorariosProfesorMateria::find()
        ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
        ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
        ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
        ->andWhere(['grupos.activo' => 0])
        ->groupBy(['horarios_profesor_materia.id_grupo'])->asArray()->all();

      $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre_grupo');
      
      return $this->render('asistencia', [
        'grupos' => $grupos
      ]);
    }

     public function actionCalificaciones(){
      $id_profesor = Yii::$app->user->identity->id_responsable;
      //obtiene los grupos a los que da materias el profesor
      $lista_grupos = HorariosProfesorMateria::find()
        ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
        ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
        ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
        ->andWhere(['grupos.activo' => 0])
        ->groupBy(['horarios_profesor_materia.id_grupo'])->asArray()->all();

      $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre_grupo');
      
      return $this->render('calificaciones', [
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
      $searchModel = new AsistenciaAlumnoSearch();
      $dataProvider = $searchModel->searchAsistencias(Yii::$app->request->queryParams,$id_profesor);

        return $this->render('reporteasistencias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCargaralumnos(){
      $datos = Yii::$app->request->get();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $busca_grupo = Grupos::findOne($id_grupo);
      if(is_null($busca_grupo)){
        $data = [
          "code" => 422,
          "mensaje" => "Grupo no existe.",
        ];
        return json_encode($data);
      }

      $semestre_bloque = \common\helpers\UtilidadesHelper::calculaSemestreBloque($busca_grupo);
      if(is_null($semestre_bloque)){
        $data = [
          "code" => 422,
          "mensaje" => "Ocurrió un error al obtener semestre y bloque, contacte al administrador .",
        ];
        return json_encode($data);
      }
      $semestre = $semestre_bloque['semestre'];
      $bloque = $semestre_bloque['bloque'];
      
      $alumnos = '
      <div style="font-size:18px;color: brown;margin:8px;"> Asistencia del Semestre '.$semestre.', Bloque '.$bloque.'</div>
      <form  method="post">
        <table class="table">
            <tbody>
                <tr >
                    <th style="border:1px solid #252525;color:#092F87">Nombre Alumno</th>
                    <th style="border:1px solid #252525;color:#092F87">Asistencia</th>
                </tr>';
      $busca_alumnos = Alumnos::findAll(["id_grupo" => $id_grupo,'activo' => 0]);
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

    public function actionCargaralumnoscal(){
      $datos = Yii::$app->request->get();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);
      $busca_grupo = Grupos::findOne($id_grupo);
      if(is_null($busca_grupo)){
        $data = [
          "code" => 422,
          "mensaje" => "Grupo no existe.",
        ];
        return json_encode($data);
      }

      $semestre_bloque = \common\helpers\UtilidadesHelper::calculaSemestreBloque($busca_grupo);
      if(is_null($semestre_bloque)){
        $data = [
          "code" => 422,
          "mensaje" => "Ocurrió un error al obtener semestre y bloque, contacte al administrador .",
        ];
        return json_encode($data);
      }
      $semestre = $semestre_bloque['semestre'];
      $bloque = $semestre_bloque['bloque'];
      
      $no_evaluacion = 0;

      $id_profesor = Yii::$app->user->identity->id_responsable;
      
      $alumnos = '
       <div style="font-size:18px;color: brown;margin:8px;"> Calificaciones del Semestre '.$semestre.', Bloque '.$bloque.'</div>
      <form method="post">
        <table class="table">
            <tbody>
                <tr >
                    <th style="border:1px solid #252525;color:#092F87">Matrícula</th>
                    <th style="border:1px solid #252525;color:#092F87">Nombre Alumno</th>
                    <th style="border:1px solid #252525;color:#092F87">Cal. Primer Parcial</th>
                    <th style="border:1px solid #252525;color:#092F87">Cal. Segundo Parcial</th>
                    <th style="border:1px solid #252525;color:#092F87">Promedio</th>
                </tr>';
      $busca_alumnos = Alumnos::findAll(["id_grupo" => $id_grupo,'activo' => 0]);
      if(!empty($busca_alumnos)){
        foreach ($busca_alumnos as $key => $alumno) {
          $busca_primer_calificacion_alumno = CalificacionAlumno::findOne([
            'id_alumno' => $alumno->id_alumno,
            'id_materia' => $id_materia,
            'id_grupo' => $id_grupo,
            'id_profesor' => $id_profesor,
            'semestre' => $semestre,
            'bloque' => $bloque,
            'no_evaluacion' => 1
          ]);

          $busca_segunda_calificacion_alumno = CalificacionAlumno::findOne([
            'id_alumno' => $alumno->id_alumno,
            'id_materia' => $id_materia,
            'id_grupo' => $id_grupo,
            'id_profesor' => $id_profesor,
            'semestre' => $semestre,
            'bloque' => $bloque,
            'no_evaluacion' => 2
          ]);

          if(is_null($busca_primer_calificacion_alumno)){
            $input_primera = "<input type='number' id='1-".$alumno->id_alumno."'  min='5' max='10'>";
            $input_segunda = "-";
          }else{
            $no_evaluacion = 1;
            if($busca_primer_calificacion_alumno->campo_editable == 1){
              if(!is_null($busca_primer_calificacion_alumno)){
                $disabled = ($busca_primer_calificacion_alumno->campo_editable)==1?"disabled":"";
                $input_primera = "<input type='number' value='".$busca_primer_calificacion_alumno->calificacion."' ".$disabled." id='1-".$alumno->id_alumno."'  min='0' max='10'>";
              }else{
                $input_primera = "<input type='number' id='1-".$alumno->id_alumno."'  min='5' max='10'>";
              }
              if (!is_null($busca_segunda_calificacion_alumno)) {
                $no_evaluacion = 2;
                $disabled = ($busca_segunda_calificacion_alumno->campo_editable)==1?"disabled":"";
                $input_segunda = "<input type='number' value='".$busca_segunda_calificacion_alumno->calificacion."' ".$disabled." id='2-".$alumno->id_alumno."'  min='0' max='10'>";
              }else{
                $no_evaluacion = 0;
                $input_segunda = "<input type='number' id='2-".$alumno->id_alumno."'  min='5' max='10'>";
              }
            }else{
              $disabled = ($busca_primer_calificacion_alumno->campo_editable)==1?"disabled":"";
              $input_primera = "<input type='number' value='".$busca_primer_calificacion_alumno->calificacion."' ".$disabled." id='1-".$alumno->id_alumno."'  min='0' max='10'>";
              $input_segunda = "-";
            }
          }

          $promedio = "-";
          if(!is_null($busca_primer_calificacion_alumno) && !is_null($busca_segunda_calificacion_alumno)){
            $promedio = ($busca_primer_calificacion_alumno->calificacion+$busca_segunda_calificacion_alumno->calificacion)/2;
            $promedio = floor($promedio);
            $promedio = number_format($promedio, 2, '.', '');
          }
          $background = (is_numeric($promedio) && $promedio < 7)?"#F76969":"white";
          $alumnos .= 
          "<tr style='background:".$background.";  ' >
            <td  style='white-space: nowrap;border:1px solid #252525;'> 
              <b style='color: #252525;' >".$alumno->matricula."</b>
            </td>
            <td width='35%' style='white-space: nowrap;border:1px solid #252525;'> 
              <b style='color: #252525;' >".$alumno->nombreCompleto."</b>
            </td>
            <td  style='white-space: nowrap;border:1px solid #252525;'> 
               ".$input_primera."
            </td>
            <td  style='white-space: nowrap;border:1px solid #252525;'> 
               ".$input_segunda."
            </td>
            <td  style='white-space: nowrap;border:1px solid #252525;'> 
               <p> ".$promedio."</p>
            </td>
          </tr>
          ";
        }
      }
      $alumnos .= "<tr>";
      $busca_primer_calificacion_alumno_registrada = CalificacionAlumno::findOne([
        'id_materia' => $id_materia,
        'id_grupo' => $id_grupo,
        'id_profesor' => $id_profesor,
        'semestre' => $semestre,
        'bloque' => $bloque,
        'no_evaluacion' => 1,
        'campo_editable' => 1
      ]);
      $busca_segunda_calificacion_alumno_registrada = CalificacionAlumno::findOne([
        'id_materia' => $id_materia,
        'id_grupo' => $id_grupo,
        'id_profesor' => $id_profesor,
        'semestre' => $semestre,
        'bloque' => $bloque,
        'no_evaluacion' => 2,
        'campo_editable' => 1
      ]);
      if(is_null($busca_primer_calificacion_alumno_registrada) | is_null($busca_segunda_calificacion_alumno_registrada) ){
         $alumnos .= 
          "<td style='background-color:white' colspan='2'> 
              <br><center><button type='button' onclick='guardarCalificacion()' class='btn btn-success'> Guardar Calificaciones </button></center>
            </td>";
        if ($no_evaluacion > 0) {
          $alumnos .= "
             <td style='background-color:white' colspan='2'> 
                <br><center><button type='button' onclick='confirmarRegistro(".$no_evaluacion.")' class='btn btn-warning'> Registrar Calificaciones </button></center>
              </td>
          ";
        }
      }
      $alumnos .= "
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


     public function actionGuardarcalificaciones(){
      $datos = Yii::$app->request->post();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);
      $calificaciones = ArrayHelper::getValue($datos, 'calificaciones', []);
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $busca_materia = Materias::findOne($id_materia);
      $busca_profesor = Profesor::findOne($id_profesor);
      $busca_grupo = Grupos::findOne($id_grupo);
      if(is_null($busca_grupo)){
      $data = [
          "code" => 422,
          "mensaje" => "Grupo no existe.",
        ];
        return json_encode($data);
      }

      $semestre_bloque = \common\helpers\UtilidadesHelper::calculaSemestreBloque($busca_grupo);
      //print_r($datos);die();
      if(is_null($semestre_bloque)){
        $data = [
          "code" => 422,
          "mensaje" => "Ocurrió un error al obtener semestre y bloque, contacte al administrador .",
        ];
        return json_encode($data);
      }
      $semestre = $semestre_bloque['semestre'];
      $bloque = $semestre_bloque['bloque'];

      
      if(!empty($calificaciones) && !is_null($busca_materia) && !is_null($busca_profesor) && $semestre > 0 && $bloque > 0 && $id_grupo > 0  ){
        foreach ($calificaciones as $key => $calificacion) {
          $array_alumno = explode("-", $calificacion['id_alumno']);
          if(isset($array_alumno[0]) && isset($array_alumno[1]) && $calificacion['calificacion'] > 1 ){
            $numero_evaluacion = $array_alumno[0];
            $id_alumno = $array_alumno[1];
            $busca_calificacion = CalificacionAlumno::findOne([
              'no_evaluacion' => $numero_evaluacion,
              'id_alumno' => $id_alumno,
              'id_materia' => $id_materia,
              'id_grupo' => $id_grupo,
              'id_profesor' => $id_profesor,
              'semestre' => $semestre,
              'bloque' => $bloque,
            ]);
            if(!is_null($busca_calificacion)){
              if( $busca_calificacion->campo_editable == 0 ){
                $busca_calificacion->calificacion = $calificacion['calificacion'];
                $busca_calificacion->fecha_actualizacion = Yii::$app->formatter->asDate('now', 'php:Y-m-d');
                $busca_calificacion->save(false);
              }else{
                $data = [
                  "code" => 422,
                  "mensaje" => "Lo sentimos ya no puede modificar las calificaciones en este periodo.",
                ];
                return json_encode($data);
              }
            }else{
              //inserta calificacion
              $inserta_calificacion = new CalificacionAlumno();
              $inserta_calificacion->no_evaluacion = $numero_evaluacion;
              $inserta_calificacion->calificacion = $calificacion['calificacion'];
              $inserta_calificacion->id_alumno = $id_alumno;
              $inserta_calificacion->id_materia = $id_materia;
              $inserta_calificacion->id_profesor = $id_profesor;
              $inserta_calificacion->id_grupo = $id_grupo;
              $inserta_calificacion->semestre = $semestre;
              $inserta_calificacion->bloque = $bloque;
              $inserta_calificacion->fecha_alta = Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');
              $inserta_calificacion->fecha_actualizacion = Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');
              $inserta_calificacion->nombre_materia = $busca_materia->nombre;
              $inserta_calificacion->nombre_profesor = $busca_profesor->nombreCompleto;
              $inserta_calificacion->save(false);
              
            }
          }
        }
        $data = [
          "code" => 200,
          "mensaje" => "Éxito",
        ];
        return json_encode($data);
      }else{
        $data = [
            "code" => 422,
            "mensaje" => "Ocurrió un error al guardar las calificaciones, verifique que grupo, materia, semestre y Bloque sean válidos.",
        ];
      }
      
      return json_encode($data);
    }

    public function actionRegistrarcalificaciones(){
      $datos = Yii::$app->request->post();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);
      $numero_evaluacion = ArrayHelper::getValue($datos, 'no_evaluacion', 0);
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $busca_materia = Materias::findOne($id_materia);
      $busca_profesor = Profesor::findOne($id_profesor);
      $busca_grupo = Grupos::findOne($id_grupo);
      if(is_null($busca_grupo)){
        $data = [
          "code" => 422,
          "mensaje" => "Grupo no existe.",
        ];
        return json_encode($data);
      }

      $semestre_bloque = \common\helpers\UtilidadesHelper::calculaSemestreBloque($busca_grupo);
      if(is_null($semestre_bloque)){
        $data = [
          "code" => 422,
          "mensaje" => "Ocurrió un error al obtener semestre y bloque, contacte al administrador .",
        ];
        return json_encode($data);
      }
      $semestre = $semestre_bloque['semestre'];
      $bloque = $semestre_bloque['bloque'];
      
      if(!is_null($busca_materia) && !is_null($busca_profesor) && $semestre > 0 && $bloque > 0 && $id_grupo > 0 ){
        //actualiza campo a no editable
        CalificacionAlumno::updateAll([   // field to be updated in first array
          'campo_editable' => 1,
        ],
        [  // conditions in second array
          'no_evaluacion' => $numero_evaluacion,
          'id_materia' => $id_materia,
          'id_grupo' => $id_grupo,
          'id_profesor' => $id_profesor,
          'semestre' => $semestre,
          'bloque' => $bloque,
        ]);
        $data = [
          "code" => 200,
          "mensaje" => "Éxito",
        ];
        
      }else{
        $data = [
            "code" => 422,
            "mensaje" => "Ocurrió un error al registrar las calificaciones, verifique que grupo, materia, semestre y Bloque sean válidos.",
        ];
      }
      
      return json_encode($data);
    }

    public function actionGuardarasistencia(){
      $datos = Yii::$app->request->post();
      $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
      $id_materia = ArrayHelper::getValue($datos, 'id_materia', 0);
      $asistencia = ArrayHelper::getValue($datos, 'asistencia', []);
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $busca_materia = Materias::findOne($id_materia);
      $busca_profesor = Profesor::findOne($id_profesor);
      $busca_grupo = Grupos::findOne($id_grupo);

      if(!empty($asistencia) && !is_null($busca_grupo) && !is_null($busca_materia) && !is_null($busca_profesor)){
        //calcula semestre y bloque actual
        $semestre_bloque = \common\helpers\UtilidadesHelper::calculaSemestreBloque($busca_grupo);
        if(is_null($semestre_bloque)){
          $data = [
            "code" => 422,
            "mensaje" => "Ocurrió un error al obtener semestre y bloque, contacte al administrador .",
          ];
        }
        $semestre = $semestre_bloque['semestre'];
        $bloque = $semestre_bloque['bloque'];
        $busca_asistencia = AsistenciaAlumno::findAll([
          'fecha_asistencia' => Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
          'id_materia' => $id_materia,
          'id_profesor' => $id_profesor,
          'id_grupo' => $id_grupo,
          'semestre' => $semestre,
          'bloque' => $bloque,
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
            $guarda_asistencia->bloque = $bloque;
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
            "mensaje" => "Ocurrió un error al guardar la asistencia, verifique que grupo, materia, semestre y Bloque sean válidos.",
        ];
      }
      
      return json_encode($data);
    }


    public function actionVerasistencias(){
      $datos = Yii::$app->request->get();
      $id_asistencia_alumno = ArrayHelper::getValue($datos, 'id_asistencia_alumno', 0);
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $busca_asistencia = AsistenciaAlumno::findOne($id_asistencia_alumno);
      
      if(!is_null($busca_asistencia)){
        $busca_alumnos = AsistenciaAlumno::find()
        ->select('asistencia_alumno.asistio,alumnos.*')
        ->innerJoin( 'alumnos','asistencia_alumno.id_alumno = alumnos.id_alumno')
        ->where([
          'asistencia_alumno.id_materia' => $busca_asistencia->id_materia,
          'asistencia_alumno.id_profesor' => $busca_asistencia->id_profesor,
          'asistencia_alumno.id_grupo' => $busca_asistencia->id_grupo,
          'asistencia_alumno.semestre' => $busca_asistencia->semestre,
          'asistencia_alumno.bloque' => $busca_asistencia->bloque,
          'asistencia_alumno.fecha_asistencia' => $busca_asistencia->fecha_asistencia
        ])->asArray()->all();
        $alumnos = '
          <table class="table">
              <tbody>
                  <tr >
                      <th style="border:1px solid #252525;color:#092F87">Nombre Alumno</th>
                      <th style="border:1px solid #252525;color:#092F87">Asistencia</th>
                  </tr>';
        if(!empty($busca_alumnos)){
          foreach ($busca_alumnos as $key => $alumno) {
            if($alumno['asistio'] == 1){
              $alumnos .= "
              <tr>
              <td width='35%' style='white-space: nowrap;border:1px solid #252525;'> 
                <b style='color: #252525;' >".$alumno['nombre']." ".$alumno['apellido_paterno']." ".$alumno['apellido_materno']."</b>
              </td>
              <td style='white-space: nowrap;border:1px solid #252525;'> 
                 <p style='color:green;'> Asistió </p>
              </td>";
            }else{
              $alumnos .= "
              <tr>
              <td width='35%' style='white-space: nowrap;border:1px solid #252525;'> 
                <b style='color: #252525;' >".$alumno['nombre']." ".$alumno['apellido_paterno']." ".$alumno['apellido_materno']."</b>
              </td>
              <td style='white-space: nowrap;border:1px solid #252525;'> 
                 <p style='color:red;'> No Asistió </p>
              </td>";
            }
            $alumnos .= "</tr>";
          }
        }
        $alumnos .="
            </tbody>
        </table>
        ";
        $data = [
          "code" => 200,
          "tabla" => $alumnos,
          "mensaje" => "Éxito",
        ];
      }else{
         $data = [
            "code" => 422,
            "mensaje" => "Ocurrió un error al cargar las asistencias.",
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
      $txt = "";
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $lista_materias = HorariosProfesorMateria::find()
      ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
      ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
      ->innerJoin( 'materias','horarios_profesor_materia.id_materia = materias.id_materia')
      ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
      ->andWhere(['horarios_profesor_materia.id_grupo' => $id])
      ->andWhere(['grupos.activo' => 0])
      ->andWhere(['materias.activo' => 0])
      ->groupBy(['horarios_profesor_materia.id_materia'])->asArray()->all();
      if(!empty($lista_materias)){
          $txt .= "<option value=''> Seleccione Materia ...</option>";
          foreach ($lista_materias as $key => $materia) {
              $txt .= "<option value='".$materia['id_materia']."'>".$materia['nombre_materia']."</option>";
          }
      }else{
          $txt .= "<option value=''> No hay Materias ...</option>";
      }
      return $txt;
    }

    public function actionBuscasemestremateria(){
      $txt = "";
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
        $txt .= "<option value=''>Seleccione Semestre ...</option>";
        foreach ($busca_semestre as $key => $value) {
          $txt .= "<option value='".$value->semestre."'> Semestre ".$value->semestre."</option>";
        }
      }else{
        $txt .= "<option value=''> No hay semestres ...</option>";
      }
      return $txt;
    }

     /**
     * Vista del rol profesor.
     * @return mixed
     */
    public function actionBuscasemestre($id)
    {
      $txt = "";
      $semestres_grupo = HorariosProfesorMateria::find()->where(['id_grupo' => $id])->groupBy(['semestre','id_grupo'])->all();
      if(!empty($semestres_grupo)){
        $txt .= "<option value=''>Seleccione Semestre ...</option>";
        foreach ($semestres_grupo as $key => $value) {
          $txt .= "<option value='".$value->semestre."'> Semestre ".$value->semestre."</option>";
        }
      }else{
        $txt .= "<option value=''> No hay semestres ...</option>";
      }
      return $txt;
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
      $bloque = ArrayHelper::getValue($datos, 'bloque', 0);
      if($semestre > 0 && $generacion > 0 && $bloque > 0){
        $busca_dias_horario = HorariosProfesorMateria::find()
          ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo','grupos.generacion'])
          ->innerJoin( 'grupos','horarios_profesor_materia.id_grupo = grupos.id_grupo')
          ->where([
            'horarios_profesor_materia.id_profesor' => $id_profesor,
            'horarios_profesor_materia.semestre' => $semestre,
            'horarios_profesor_materia.bloque' => $bloque,
            'grupos.generacion' => $generacion,
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
                          'horarios_profesor_materia.id_profesor' => $id_profesor,
                          'horarios_profesor_materia.semestre' => $semestre,
                          'horarios_profesor_materia.bloque' => $bloque,
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
                          'horarios_profesor_materia.id_profesor' => $id_profesor,
                          'horarios_profesor_materia.bloque' => $bloque,
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
                          'horarios_profesor_materia.id_profesor' => $id_profesor,
                          'horarios_profesor_materia.semestre' => $semestre,
                          'horarios_profesor_materia.bloque' => $bloque,
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
                          'horarios_profesor_materia.id_profesor' => $id_profesor,
                          'horarios_profesor_materia.semestre' => $semestre,
                          'horarios_profesor_materia.bloque' => $bloque,
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
                          'horarios_profesor_materia.id_profesor' => $id_profesor,
                          'horarios_profesor_materia.semestre' => $semestre,
                          'horarios_profesor_materia.bloque' => $bloque,
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
                          'horarios_profesor_materia.id_profesor' => $id_profesor,
                          'horarios_profesor_materia.semestre' => $semestre,
                          'horarios_profesor_materia.bloque' => $bloque,
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

    public function actionTemario(){
      $id_profesor = Yii::$app->user->identity->id_responsable;
      $searchModel = new HorariosProfesorMateriaSearch();
      $dataProvider = $searchModel->searchGruposProfesor(Yii::$app->request->queryParams,$id_profesor);

        return $this->render('temario', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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
