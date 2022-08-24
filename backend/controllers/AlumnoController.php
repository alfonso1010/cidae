<?php

namespace backend\controllers;

use Yii;
use yii\web\Controller;
use common\models\User;
use yii\web\UploadedFile;
use common\models\Grupos;
use common\models\Alumnos;
use yii\filters\VerbFilter;
use common\models\Profesor;
use common\models\Materias;
use common\models\Carreras;
use yii\helpers\ArrayHelper;
use common\models\AlumnosSearch;
use common\models\PagosAlumno;
use common\models\PagosAlumnoSearch;
use yii\web\NotFoundHttpException;
use common\models\ProfesorMateria;
use common\models\BibliotecaDigital;
use common\models\BibliotecaDigitalSearch;
use common\models\FormatoAlumnos;
use common\models\FormatoAlumnosSearch;
use common\models\AvisosSearch;
use common\models\CalificacionAlumno;
use common\models\HorariosProfesorMateria;

/**
 * AlumnosController implements the CRUD actions for Alumnos model.
 */
class AlumnoController extends Controller
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
        $searchModel = new FormatoAlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('formatos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    /**
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionPrincipal()
    {
        $id_alumno = Yii::$app->user->identity->id_responsable;
        $busca_alumno = Alumnos::findOne(['id_alumno' => $id_alumno, 'activo' => 0]);
        if(is_null($busca_alumno)){
            Yii::$app->user->logout();
            return $this->goHome();
        }
    
        return $this->render('principal', [
            'busca_alumno' => $busca_alumno
        ]);
   
       
    }

    /**
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionCalificaciones()
    {
        $id_alumno = Yii::$app->user->identity->id_responsable;
        $busca_alumno = Alumnos::findOne($id_alumno);
        if(is_null($busca_alumno)){
            Yii::$app->user->logout();
            return $this->goHome();
        }
        $busca_grupo = Grupos::findOne($busca_alumno->id_grupo);
        if(is_null($busca_grupo)){
          Yii::$app->session->setFlash(
            'danger',
            'No se encontró el grupo del alumno, Contacte con el administrador.'
          );
          return $this->redirect(["alumno/principal"]);
        }

        $semestre_bloque = \common\helpers\UtilidadesHelper::calculaSemestreBloque($busca_grupo);
        if(is_null($semestre_bloque)){
          Yii::$app->session->setFlash(
            'danger',
             "Ocurrió un error al obtener semestre y bloque, contacte al administrador ."
          );
          return $this->redirect(["alumno/principal"]);
        }
        
        return $this->render('calificaciones', [
            'busca_alumno' => $busca_alumno,
            'grupo' => $busca_grupo,
            'semestre_bloque' => $semestre_bloque
        ]);
    }

      /**
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionPagos()
    {
        $id_alumno = Yii::$app->user->identity->id_responsable;
        $busca_alumno = Alumnos::findOne($id_alumno);
        if(is_null($busca_alumno)){
            Yii::$app->user->logout();
            return $this->goHome();
        }

        $model_pagos = new PagosAlumno();
        $searchModel = new PagosAlumnoSearch();
        $dataProvider = $searchModel->searchByAlumno(Yii::$app->request->queryParams,$id_alumno);

        $request = Yii::$app->request;
        if ($request->isPost){
          $model_pagos->load(Yii::$app->request->post());
          $model_pagos->estatus_pago = 0;
          $model_pagos->id_alumno = $id_alumno;
          $model_pagos->fecha_alta = Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');
          $model_pagos->fecha_actualizacion = Yii::$app->formatter->asDate('now', 'php:Y-m-d h:i:s');
          $model_pagos->file_recibo = UploadedFile::getInstance($model_pagos, 'file_recibo');
          $model_pagos->uploadFiles();
          if ( $model_pagos->save()) {
            Yii::$app->session->setFlash(
              'success',
              'Pago Registrado con Éxito.'
            );
            return $this->redirect(['pagos']);
          }
        }
    
        return $this->render('pagos', [
            'busca_alumno' => $busca_alumno,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelPagos' => $model_pagos,
        ]);
   
       
    }



    /**
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionBiblioteca()
    {
        $id_alumno = Yii::$app->user->identity->id_responsable;
        $busca_alumno = Alumnos::findOne($id_alumno);
        if(is_null($busca_alumno)){
            Yii::$app->user->logout();
            return $this->goHome();
        }

        $searchModel = new BibliotecaDigitalSearch();
        $get = Yii::$app->request->get();
        if(isset($get['q']) && strlen($get['q']) >  0 ){
          $dataProvider = $searchModel->searchByName(Yii::$app->request->queryParams,$get['q']);
        }else{
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('biblioteca', [
             'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'busca_alumno' => $busca_alumno
        ]);
   
       
    }

     /**
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionAvisos()
    {
        $id_alumno = Yii::$app->user->identity->id_responsable;
        $busca_alumno = Alumnos::findOne($id_alumno);
        if(is_null($busca_alumno)){
            Yii::$app->user->logout();
            return $this->goHome();
        }

        $searchModel = new AvisosSearch();
        $dataProvider = $searchModel->searchAlumno(Yii::$app->request->queryParams);
        
        return $this->render('avisos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'busca_alumno' => $busca_alumno
        ]);
   
       
    }

     /**
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionCargaCalificaciones()
    {
        $datos = Yii::$app->request->post();
        $id_alumno = Yii::$app->user->identity->id_responsable;
        $busca_alumno = Alumnos::findOne($id_alumno);
        $semestre = ArrayHelper::getValue($datos, 'semestre', 0);
        $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
        $bloque = ArrayHelper::getValue($datos, 'bloque', 0);
        $data = [
            "code" => 201,
            "tabla" => ""
        ];
        if($semestre > 0 && $id_grupo > 0 && $bloque > 0 ){
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
            $data = [
                "code" => 200,
                "tabla" => $tabla,
                "mensaje" => "Éxito",
            ];
        }
        return json_encode($data);
    }



   
}
