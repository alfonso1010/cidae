<?php

namespace backend\controllers;

use Yii;
use common\models\Alumnos;
use common\models\User;
use common\models\AlumnosSearch;
use common\models\Grupos;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * AlumnosController implements the CRUD actions for Alumnos model.
 */
class AlumnosController extends Controller
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
    public function actionIndex()
    {
        $searchModel = new AlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Alumnos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Alumnos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Alumnos();

        $lista_grupos = Grupos::find()->where(['activo' => 0])->all();
        $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            //guarda  usuario de alumno
            
            $user_alumno = new User();
            $user_alumno->username = $model->email;
            $user_alumno->email = $model->email;
            $user_alumno->status = User::STATUS_ACTIVE;
            $user_alumno->id_responsable = $model->id_alumno;
            $user_alumno->tipo_responsable = 2;
            $user_alumno->setPassword($model->matricula);
            $user_alumno->generateAuthKey();
            $user_alumno->generatePasswordResetToken();
            
            if($user_alumno->save()){
                //asigna rol
                User::asignaRol($user_alumno->id,"alumno");
            }else{
                //print_r($user_alumno->getFirstErrors());die();
                $model->delete();
                Yii::$app->session->setFlash(
                    'danger',
                    'No se pudo crear el alumno, Contacte con el administrador.'
                );
                return $this->render('create', [
                    'model' => $model,
                    'grupos' => $grupos,
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id_alumno]);
        }

        return $this->render('create', [
            'model' => $model,
            'grupos' => $grupos,
        ]);
    }

    /**
     * Updates an existing Alumnos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $lista_grupos = Grupos::find()->where(['activo' => 0])->all();
        $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $user_alumno = User::findOne(['id_responsable' => $model->id_alumno,'tipo_responsable' => 2]);
            if(!is_null($user_alumno)){
                $user_alumno->setPassword($model->matricula);
                $user_alumno->save();
            }
            return $this->redirect(['view', 'id' => $model->id_alumno]);
        }

        return $this->render('update', [
            'model' => $model,
            'grupos' => $grupos,
        ]);
    }

    /**
     * Deletes an existing Alumnos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Alumnos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Alumnos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Alumnos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
