<?php

namespace backend\controllers;

use Yii;
use common\models\Alumnos;
use common\models\User;
use common\models\AlumnosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use common\models\Profesor;
use common\models\ProfesorMateria;
use common\models\Materias;
use common\models\HorariosProfesorMateria;
use common\models\Carreras;
use common\models\Grupos;

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
     * Lists all Alumnos models.
     * @return mixed
     */
    public function actionPrincipal()
    {
        $id_alumno = Yii::$app->user->identity->id_responsable;
        $busca_alumno = Alumnos::findOne($id_alumno);
        if(is_null($busca_alumno)){
            Yii::$app->user->logout();
            return $this->goHome();
        }
      
        
        return $this->render('principal', [
            'busca_alumno' => $busca_alumno
        ]);
   
       
    }

   
}
