<?php

namespace backend\controllers;

use Yii;
use common\models\Materias;
use common\models\MateriasSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Carreras;
use yii\helpers\ArrayHelper;

/**
 * MateriasController implements the CRUD actions for Materias model.
 */
class MateriasController extends Controller
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
     * Lists all Materias models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MateriasSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Materias model.
     * @param integer $id_materia
     * @param integer $id_carrera
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id_materia, $id_carrera)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_materia, $id_carrera),
        ]);
    }

    /**
     * Creates a new Materias model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Materias();
        $lista_carreras = Carreras::find()->where(['activo' => 0])->all();
        $carreras = ArrayHelper::map($lista_carreras, 'id_carrera', 'nombre');
        
        $model->load(Yii::$app->request->post());
        if(is_array($model->mes_periodo) && !empty($model->mes_periodo)){
            $meses = "";
            foreach ($model->mes_periodo as $key => $mes) {
                $meses .= $mes.",";
            }
            $model->mes_periodo = trim($meses,",");
        }
        if ( $model->save()) {
            return $this->redirect(['view', 'id_materia' => $model->id_materia, 'id_carrera' => $model->id_carrera]);
        }

        return $this->render('create', [
            'model' => $model,
            'carreras' => $carreras
        ]);
    }

    /**
     * Updates an existing Materias model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id_materia
     * @param integer $id_carrera
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id_materia, $id_carrera)
    {
        $model = $this->findModel($id_materia, $id_carrera);

        $lista_carreras = Carreras::find()->where(['activo' => 0])->all();
        $carreras = ArrayHelper::map($lista_carreras, 'id_carrera', 'nombre');

        $model->load(Yii::$app->request->post());
        if(is_array($model->mes_periodo) && !empty($model->mes_periodo)){
            $meses = "";
            foreach ($model->mes_periodo as $key => $mes) {
                $meses .= $mes.",";
            }
            $model->mes_periodo = trim($meses,",");
        }

        if ($model->save()) {
            return $this->redirect(['view', 'id_materia' => $model->id_materia, 'id_carrera' => $model->id_carrera]);
        }

        return $this->render('update', [
            'model' => $model,
            'carreras' => $carreras
        ]);
    }

    /**
     * Deletes an existing Materias model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id_materia
     * @param integer $id_carrera
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id_materia, $id_carrera)
    {
        $this->findModel($id_materia, $id_carrera)->delete();

        return $this->redirect(['index']);
    }


    public function actionBuscasemestre($id)
    {
        $txt_semestre = "";
        $carrera = Carreras::findOne($id);   
        if(!is_null($carrera)){
            $txt_semestre .= "<option value=''>Seleccione Semestre ...</option>";
            for ($i=0; $i < $carrera->total_periodos ; $i++) { 
                $s = $i+1;
                $txt_semestre .= "<option value='".$s."'> Semestre ".$s."</option>";
            }
        }else{
            $txt_semestre .= "<option value=''> No hay semestres ...</option>";
        }
        return $txt_semestre;
    }

    /**
     * Finds the Materias model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id_materia
     * @param integer $id_carrera
     * @return Materias the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_materia, $id_carrera)
    {
        if (($model = Materias::findOne(['id_materia' => $id_materia, 'id_carrera' => $id_carrera])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
