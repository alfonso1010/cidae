<?php

namespace backend\controllers;

use Yii;
use common\models\Grupos;
use common\models\Carreras;
use common\models\GruposSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * GruposController implements the CRUD actions for Grupos model.
 */
class GruposController extends Controller
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
     * Lists all Grupos models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GruposSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Grupos model.
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
     * Creates a new Grupos model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Grupos();

        $lista_carreras = Carreras::find()->where(['activo' => 0])->all();
        $carreras = ArrayHelper::map($lista_carreras, 'id_carrera', 'nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_grupo]);
        }

        return $this->render('create', [
            'model' => $model,
            'carreras' => $carreras
        ]);
    }

    /**
     * Updates an existing Grupos model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $lista_carreras = Carreras::find()->where(['activo' => 0])->all();
        $carreras = ArrayHelper::map($lista_carreras, 'id_carrera', 'nombre');

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_grupo]);
        }

        return $this->render('update', [
            'model' => $model,
            'carreras' => $carreras
        ]);
    }

    /**
     * Deletes an existing Grupos model.
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
     * Finds the Grupos model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Grupos the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Grupos::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
