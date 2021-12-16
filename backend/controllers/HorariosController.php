<?php

namespace backend\controllers;

use Yii;
use common\models\Horarios;
use common\models\HorariosSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HorariosController implements the CRUD actions for Horarios model.
 */
class HorariosController extends Controller
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
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HorariosSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Horarios model.
     * @param integer $id_horario
     * @param integer $id_grupo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_horario, $id_grupo)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_horario, $id_grupo),
        ]);
    }

    /**
     * Creates a new Horarios model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Horarios();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_horario' => $model->id_horario, 'id_grupo' => $model->id_grupo]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Horarios model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_horario
     * @param integer $id_grupo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_horario, $id_grupo)
    {
        $model = $this->findModel($id_horario, $id_grupo);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_horario' => $model->id_horario, 'id_grupo' => $model->id_grupo]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Horarios model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_horario
     * @param integer $id_grupo
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_horario, $id_grupo)
    {
        $this->findModel($id_horario, $id_grupo)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Horarios model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_horario
     * @param integer $id_grupo
     * @return Horarios the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_horario, $id_grupo)
    {
        if (($model = Horarios::findOne(['id_horario' => $id_horario, 'id_grupo' => $id_grupo])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
