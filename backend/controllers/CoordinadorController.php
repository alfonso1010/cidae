<?php

namespace backend\controllers;

use Yii;
use common\models\Coordinador;
use common\models\CoordinadorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Grupos;
use yii\helpers\ArrayHelper;
use common\models\User;
use yii\web\UploadedFile;
use common\models\Materias;
use common\models\MateriasSearch;

/**
 * CoordinadorController implements the CRUD actions for Coordinador model.
 */
class CoordinadorController extends Controller
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
     * Lists all Coordinador models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CoordinadorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Coordinador model.
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
     * Creates a new Coordinador model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Coordinador();
        $lista_grupos = Grupos::find()->where(['activo' => 0])->all();
        $grupos = ArrayHelper::map($lista_grupos, 'id_grupo', 'nombre');

        if ($model->load(Yii::$app->request->post()) ) {

            $arr_grupos = Yii::$app->request->post('grupos');
            $grupos_str = "";
            if (!is_null($arr_grupos)) {
                foreach ($arr_grupos as $key => $value) {
                    $grupos_str .= $value . ",";
                }
                $model->grupos = trim($grupos_str, ",");
            }

            if(!$model->save() |  strlen($model->grupos) == 0 ){
                Yii::$app->session->setFlash(
                    'error',
                    'Debe seleccionar grupos al Coordinador.'
                );
                return $this->render('create', [
                    'model' => $model,
                    'grupos' => $grupos,
                ]);
            }
            $user_coordinador = new User();
            $user_coordinador->username = $model->email;
            $user_coordinador->email = $model->email;
            $user_coordinador->status = User::STATUS_ACTIVE;
            $user_coordinador->id_responsable = $model->id_coordinador;
            $user_coordinador->tipo_responsable = 3;
            $user_coordinador->setPassword($model->matricula);
            $user_coordinador->generateAuthKey();
            $user_coordinador->generatePasswordResetToken();
            
            if($user_coordinador->save()){
                //asigna rol
                User::asignaRol($user_coordinador->id,"coordinador");
                //carga documentos
                $model->file_acta = UploadedFile::getInstance($model, 'file_acta');
                $model->file_curp = UploadedFile::getInstance($model, 'file_curp');
                $model->file_ine = UploadedFile::getInstance($model, 'file_ine');
                $model->file_comp_domi = UploadedFile::getInstance($model, 'file_comp_domi');
                $model->file_rfc = UploadedFile::getInstance($model, 'file_rfc');
                $model->file_nss = UploadedFile::getInstance($model, 'file_nss');
                $model->file_titulo = UploadedFile::getInstance($model, 'file_titulo');
                $model->file_cedula = UploadedFile::getInstance($model, 'file_cedula');
                $model->file_cv = UploadedFile::getInstance($model, 'file_cv');
                $model->uploadFiles();
            }else{
                //print_r($user_coordinador->getFirstErrors());die();
                $error = $user_coordinador->getFirstErrors();
                $error = reset($error);
                $model->delete();
                Yii::$app->session->setFlash(
                    'danger',
                    'No se pudo crear el Coordinador, Error: <BR>'.$error
                );
                return $this->render('create', [
                    'model' => $model,
                    'grupos' => $grupos,
                ]);
            }
            return $this->redirect(['view', 'id' => $model->id_coordinador]);
        }

        return $this->render('create', [
            'model' => $model,
            'grupos' => $grupos,
        ]);
    }

    /**
     * Updates an existing Coordinador model.
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

        if ($model->load(Yii::$app->request->post())) {

            $grupos = Yii::$app->request->post('grupos');
            $grupos_str = "";
            if (!is_null($grupos)) {
                foreach ($grupos as $key => $value) {
                    $grupos_str .= $value . ",";
                }
                $model->grupos = trim($grupos_str, ",");
            }
            if(!$model->save() | $model->grupos == "" ){
                Yii::$app->session->setFlash(
                    'error',
                    'Debe seleccionar grupos al Coordinador.'
                );
                return $this->render('create', [
                    'model' => $model,
                    'grupos' => $grupos,
                ]);
            }

            $user_coordinador = User::findOne(['id_responsable' => $model->id_coordinador,'tipo_responsable' => 3]);
            if(!is_null($user_coordinador)){
                $user_coordinador->setPassword($model->matricula);
                $user_coordinador->save();
                //carga documentos
                $model->file_acta = UploadedFile::getInstance($model, 'file_acta');
                $model->file_curp = UploadedFile::getInstance($model, 'file_curp');
                $model->file_ine = UploadedFile::getInstance($model, 'file_ine');
                $model->file_comp_domi = UploadedFile::getInstance($model, 'file_comp_domi');
                $model->file_rfc = UploadedFile::getInstance($model, 'file_rfc');
                $model->file_nss = UploadedFile::getInstance($model, 'file_nss');
                $model->file_titulo = UploadedFile::getInstance($model, 'file_titulo');
                $model->file_cedula = UploadedFile::getInstance($model, 'file_cedula');
                $model->file_cv = UploadedFile::getInstance($model, 'file_cv');
                $model->uploadFiles();
            }
            return $this->redirect(['view', 'id' => $model->id_coordinador]);
        }

        return $this->render('update', [
            'model' => $model,
            'grupos' => $grupos,
        ]);
    }

     public function actionTemario(){
      $id_coordinador = Yii::$app->user->identity->id_responsable;
      $busca_cordi = Coordinador::findOne($id_coordinador);
      if(is_null($busca_cordi)){
          Yii::$app->user->logout();
          return $this->goHome();
      }
      $carreras_cordi = Grupos::find()->select('id_carrera')->where('id_grupo IN ('.$busca_cordi->grupos.')')->groupBy(['id_carrera'])->asArray()->all();
      $in_carreas = "";
      foreach ($carreras_cordi as $key => $carrera) {
          $in_carreas .= $carrera['id_carrera'].",";
      }
      $in_carreas = trim($in_carreas, ",");
      $searchModel = new MateriasSearch();
      $dataProvider = $searchModel->searchCoordinador(Yii::$app->request->queryParams,$in_carreas);

        return $this->render('temario', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Deletes an existing Coordinador model.
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
     * Finds the Coordinador model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Coordinador the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Coordinador::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
