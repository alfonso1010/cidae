<?php

namespace backend\controllers;

use Yii;
use common\models\FormatoAlumnos;
use common\models\FormatoAlumnosSearch;
use common\models\FormatoDocentes;
use common\models\FormatoDocentesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * FormatosController implements the CRUD actions for FormatoAlumnos model.
 */
class FormatosController extends Controller
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
     * Lists all FormatoAlumnos models.
     * @return mixed
     */
    public function actionAlumnos()
    {
        $searchModel = new FormatoAlumnosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('alumnos/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FormatoAlumnos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewAlumno($id)
    {
        return $this->render('alumnos/view', [
            'model' => $this->findModelAlumno($id),
        ]);
    }

    /**
     * Creates a new FormatoAlumnos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAlumno()
    {
        $model = new FormatoAlumnos();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->file_formato = UploadedFile::getInstance($model, 'file_formato');
            $model->uploadFiles();
            if($model->save()){
                return $this->redirect(['alumnos']);
            }
        }

        return $this->render('alumnos/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FormatoAlumnos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateAlumno($id)
    {
        $model = $this->findModelAlumno($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->file_formato = UploadedFile::getInstance($model, 'file_formato');
            $model->uploadFiles();
            if($model->save()){
                return $this->redirect(['alumnos']);
            }
        }

        return $this->render('alumnos/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FormatoAlumnos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteAlumno($id)
    {
        $this->findModelAlumno($id)->delete();

        return $this->redirect(['alumnos']);
    }


    /**
     * Lists all FormatoAlumnos models.
     * @return mixed
     */
    public function actionDocentes()
    {
        $searchModel = new FormatoDocentesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('docentes/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FormatoAlumnos model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionViewDocente($id)
    {
        return $this->render('docentes/view', [
            'model' => $this->findModelDocente($id),
        ]);
    }

    /**
     * Creates a new FormatoAlumnos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateDocente()
    {
        $model = new FormatoDocentes();

        if ($model->load(Yii::$app->request->post()) ) {
            $model->file_formato = UploadedFile::getInstance($model, 'file_formato');
            $model->uploadFiles();
            if($model->save()){
                return $this->redirect(['docentes']);
            }
        }

        return $this->render('docentes/create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing FormatoAlumnos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateDocente($id)
    {
        $model = $this->findModelDocente($id);

        if ($model->load(Yii::$app->request->post()) ) {
            $model->file_formato = UploadedFile::getInstance($model, 'file_formato');
            $model->uploadFiles();
            if($model->save()){
                return $this->redirect(['docentes']);
            }
        }

        return $this->render('docentes/update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing FormatoAlumnos model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteDocente($id)
    {
        $this->findModelDocente($id)->delete();

        return $this->redirect(['docentes']);
    }

    /**
     * Finds the FormatoAlumnos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FormatoAlumnos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelAlumno($id)
    {
        if (($model = FormatoAlumnos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

     /**
     * Finds the FormatoAlumnos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FormatoAlumnos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModelDocente($id)
    {
        if (($model = FormatoDocentes::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
