<?php

namespace backend\controllers;

use Yii;
use common\models\BibliotecaDigital;
use common\models\BibliotecaDigitalSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * BibliotecadigitalController implements the CRUD actions for BibliotecaDigital model.
 */
class BibliotecadigitalController extends Controller
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
     * Lists all BibliotecaDigital models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BibliotecaDigitalSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BibliotecaDigital model.
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
     * Creates a new BibliotecaDigital model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BibliotecaDigital();
        $model->scenario = 'create';
        $model->categoria = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->file_libro = UploadedFile::getInstance($model, 'file_libro');
            $model->file_portada = UploadedFile::getInstance($model, 'file_portada');
            $model->uploadFiles();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_libro]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing BibliotecaDigital model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $model->categoria = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->file_libro = UploadedFile::getInstance($model, 'file_libro');
            $model->file_portada = UploadedFile::getInstance($model, 'file_portada');
            $model->uploadFiles();
            $model->save();
            return $this->redirect(['view', 'id' => $model->id_libro]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BibliotecaDigital model.
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
     * Finds the BibliotecaDigital model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BibliotecaDigital the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BibliotecaDigital::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
