<?php

namespace backend\controllers;

use Yii;
use common\models\Avisos;
use common\models\AvisosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
/**
 * AvisosController implements the CRUD actions for Avisos model.
 */
class AvisosController extends Controller
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
     * Lists all Avisos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AvisosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Avisos model.
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
     * Creates a new Avisos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Avisos();
        $model->scenario = 'create';

        if ($model->load(Yii::$app->request->post())) {
            $model->file_aviso = UploadedFile::getInstance($model, 'file_aviso');
            $model->uploadFiles();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_aviso]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Avisos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

         if ($model->load(Yii::$app->request->post())) {
            $model->file_aviso = UploadedFile::getInstance($model, 'file_aviso');
            $model->uploadFiles();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_aviso]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionPausar($id){
        $busca_aviso = Avisos::findOne($id);
        if (!is_null($busca_aviso)) {
            $busca_aviso->estatus = Avisos::PAUSADO;
            $busca_aviso->save(false);
        }
        return $this->redirect(['index']);
    }

    public function actionActivar($id){
        $busca_aviso = Avisos::findOne($id);
        if (!is_null($busca_aviso)) {
            $busca_aviso->estatus = Avisos::ACTIVO;
            $busca_aviso->save(false);
        }
        return $this->redirect(['index']);
    }

    /**
     * Deletes an existing Avisos model.
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
     * Finds the Avisos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Avisos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Avisos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
