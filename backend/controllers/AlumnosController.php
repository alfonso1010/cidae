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
use yii\web\UploadedFile;
use common\models\PagosAlumno;
use common\models\PagosAlumnoSearch;

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

    public function actionPagos(){
        $model_pagos = new PagosAlumno();
        $searchModel = new PagosAlumnoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('pagos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelPagos' => $model_pagos,
        ]);
    }

    public function actionAprobarpago($id){
        $busca_pago = PagosAlumno::findOne($id);
        if (!is_null($busca_pago)) {
            $busca_pago->estatus_pago = PagosAlumno::APROBADO;
            $busca_pago->save(false);
        }
        return $this->redirect(['pagos']);
    }

    public function actionDeclinarpago($id){
        $busca_pago = PagosAlumno::findOne($id);
        if (!is_null($busca_pago)) {
            $busca_pago->estatus_pago = PagosAlumno::DECLINADO;
            $busca_pago->save(false);
        }
        return $this->redirect(['pagos']);
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
        $model->activo = 0;
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
                $model->file_acta = UploadedFile::getInstance($model, 'file_acta');
                $model->file_curp = UploadedFile::getInstance($model, 'file_curp');
                $model->file_ine = UploadedFile::getInstance($model, 'file_ine');
                $model->file_comp_domi = UploadedFile::getInstance($model, 'file_comp_domi');
                $model->file_cert_bachi = UploadedFile::getInstance($model, 'file_cert_bachi');
                $model->uploadFiles();
            }else{
                //print_r(\Yii::getAlias('@webroot')."/docs_alumnos");die();
                print_r($user_alumno->getFirstErrors());die();
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
                $model->file_acta = UploadedFile::getInstance($model, 'file_acta');
                $model->file_curp = UploadedFile::getInstance($model, 'file_curp');
                $model->file_ine = UploadedFile::getInstance($model, 'file_ine');
                $model->file_comp_domi = UploadedFile::getInstance($model, 'file_comp_domi');
                $model->file_cert_bachi = UploadedFile::getInstance($model, 'file_cert_bachi');
                $model->uploadFiles();
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
