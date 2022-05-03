<?php

namespace backend\controllers;

use Yii;
use common\models\Alumnos;
use common\models\User;
use common\models\AlumnosSearch;
use common\models\Grupos;
use common\models\Coordinador;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use common\models\AsistenciaAlumno;
use common\models\AsistenciaAlumnoSearch;
use common\models\CalificacionAlumno;
use common\models\HorariosProfesorMateria;
use common\models\CalificacionAlumnoSearch;


class ReportesController extends Controller
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
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionAsistencias()
    {
      $datos_get = Yii::$app->request->get();
      $id_grupo = ArrayHelper::getValue($datos_get, 'id_grupo', 0);
      $semestre = ArrayHelper::getValue($datos_get, 'semestre', 0);
      $bloque = ArrayHelper::getValue($datos_get, 'bloque', 0);
      $grupos = [];
      $lista_grupos = Grupos::findAll(['activo' => 0]);
      $lista_grupos[0] = ['id_grupo' => 0, 'nombre' => "Limpiar Filtro"];
      $roles_usuario = \Yii::$app->authManager->getRolesByUser(
        Yii::$app->user->getId()
      );
      $roles_usuario =  reset($roles_usuario);
      $rol = ArrayHelper::getValue($roles_usuario, 'name', '');
      if($rol == "coordinador"){
        $busca_usuario = Coordinador::findOne(Yii::$app->user->identity->id_responsable);
        $lista_grupos = Grupos::find()->where('id_grupo IN ('.$busca_usuario->grupos.')')->andWhere(['activo' => 0])->all();
      }
      $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre');
      
      $searchModel = new AsistenciaAlumnoSearch();
      $dataProvider = $searchModel->searchAsistenciasGrupo(Yii::$app->request->queryParams,$id_grupo,$semestre,$bloque);

        return $this->render('asistencias', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'grupos' => $grupos,
            'id_grupo' => $id_grupo,
            'semestre' => $semestre,
            'bloque' => $bloque,
        ]);
    }

    public function actionCalificaciones()
    {
      $datos_get = Yii::$app->request->get();
      $id_grupo = ArrayHelper::getValue($datos_get, 'id_grupo', 0);
      $semestre = ArrayHelper::getValue($datos_get, 'semestre', 0);
      $bloque = ArrayHelper::getValue($datos_get, 'bloque', 0);
      $grupos = [];
      $lista_grupos = Grupos::findAll(['activo' => 0]);
      $lista_grupos[0] = ['id_grupo' => 0, 'nombre' => "Limpiar Filtro"];
      $roles_usuario = \Yii::$app->authManager->getRolesByUser(
        Yii::$app->user->getId()
      );
      $roles_usuario =  reset($roles_usuario);
      $rol = ArrayHelper::getValue($roles_usuario, 'name', '');
      if($rol == "coordinador"){
        $busca_usuario = Coordinador::findOne(Yii::$app->user->identity->id_responsable);
        $lista_grupos = Grupos::find()->where('id_grupo IN ('.$busca_usuario->grupos.')')->andWhere(['activo' => 0])->all();
      }
      $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre');
      
      $searchModel = new CalificacionAlumnoSearch();
      $dataProvider = $searchModel->searchCalificacionAlumnos(Yii::$app->request->queryParams,$id_grupo,$semestre,$bloque);

        return $this->render('calificaciones', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'grupos' => $grupos,
            'id_grupo' => $id_grupo,
            'semestre' => $semestre,
            'bloque' => $bloque,
        ]);
    }

    public function actionVercalificaciones()
    {
      $datos_get = Yii::$app->request->get();
      $id_grupo = ArrayHelper::getValue($datos_get, 'id_grupo', 0);
      $semestre = ArrayHelper::getValue($datos_get, 'semestre', 0);
      $bloque = ArrayHelper::getValue($datos_get, 'bloque', 0);
      $id_alumno = ArrayHelper::getValue($datos_get, 'id_alumno', 0);

      $busca_materias = HorariosProfesorMateria::find()
      ->select(['horarios_profesor_materia.id_materia','materias.nombre as nombre_materia'])
      ->innerJoin( 'materias','horarios_profesor_materia.id_materia = materias.id_materia')
      ->where([
          'horarios_profesor_materia.id_grupo' => $id_grupo,
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
            'id_alumno' => $id_alumno,
            'id_grupo' => $id_grupo,
            'semestre' => $semestre,
            'bloque' => $bloque,
            'no_evaluacion' => 1,
            'id_materia' => $materia['id_materia'],
          ]);

          $busca_segunda_calificacion_alumno = CalificacionAlumno::findOne([
            'id_alumno' => $id_alumno,
            'id_grupo' => $id_grupo,
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
          $background = (is_numeric($promedio) && $promedio < 7)?"#F76969":"white";

          $tabla .= 
          "<tr style='background:".$background."'>
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
      return json_encode([
        'code' => 200,
        'tabla' => $tabla
      ]);
    }
 
}
?>
