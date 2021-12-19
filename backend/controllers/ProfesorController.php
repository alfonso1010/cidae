<?php

namespace backend\controllers;

use Yii;
use common\models\Profesor;
use common\models\ProfesorMateria;
use common\models\Materias;
use common\models\ProfesorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * ProfesorController implements the CRUD actions for Profesor model.
 */
class ProfesorController extends Controller
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
     * Lists all Profesor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProfesorSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Profesor model.
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
     * Creates a new Profesor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Profesor();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_profesor]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Profesor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_profesor]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

   
    public function actionMaterias()
    {   
        $lista_profesores = Profesor::find()->select(["id_profesor",'concat(nombre, " ", apellido_paterno, " ", apellido_materno) as nombre_completo'])->where(['activo' => 0])->asArray()->all();
        $profesores = ArrayHelper::map($lista_profesores, 'id_profesor', 'nombre_completo');
        return $this->render('materias', [
            'profesores' => $profesores,
        ]);
    }

    public function actionBuscarmaterias($id)
    {   
        $materias_asignadas = ProfesorMateria::find()->select(['materias.id_materia','materias.nombre'])
                                ->innerJoin( 'materias','profesor_materia.id_materia = materias.id_materia')
                                ->where(["profesor_materia.id_profesor" => $id])
                                ->asArray()->all();
        $materias_disponibles = Materias::find()->select(["id_materia","nombre"])->where(['activo' => 0])->asArray()->all();
        if(!empty($materias_asignadas)){
            $in_asignadas = "";
            foreach ($materias_asignadas as $key => $asignadas) {
                $in_asignadas .= $asignadas["id_materia"].",";
            }
            $in_asignadas = trim($in_asignadas,",");
            $materias_disponibles = Materias::find()->select(["id_materia","nombre"])
                ->where(['activo' => 0])
                ->andWhere("id_materia NOT IN (".$in_asignadas.")")
                ->asArray()->all();
        }
        
        $html_asignadas = '
        <h3>Materias Asignadas</h3>
        <table id="tabla_asignadas" class="table table-bordered">
            <tbody id="fila_asignadas">
                <tr id="0">
                  <th><center>Nombre</center></th>
                  <th>Opciones</th>
                </tr>';
        foreach ($materias_asignadas as $key => $asignada) {
            $html_asignadas .= 
                '<tr id="'.$asignada['id_materia'].'" data-nombre="'.$asignada['nombre'].'" >
                  <td><center>'.$asignada['nombre'].'</center></td>
                  <td><button onclick="eliminaAsignada('.$asignada['id_materia'].')" type="button" class="btn btn-danger"><i class="fa fa-times-circle"></i></button></td>
                </tr>';
        }
        $html_asignadas .= 
        '   </tbody>
        </table>';

        $html_disponibles = '
        <h3>Materias Disponibles</h3>
        <table id="tabla_disponibles" class="table table-bordered">
            <tbody id="fila_disponibles">
                <tr>
                  <th><center>Nombre</center></th>
                  <th>Opciones</th>
                </tr>';
        foreach ($materias_disponibles as $key => $disponible) {
            $html_disponibles .= 
                '<tr id="'.$disponible['id_materia'].'" data-nombre="'.$disponible['nombre'].'"  >
                  <td><center>'.$disponible['nombre'].'</center></td>
                  <td><button onclick="agregaAsignada('.$disponible['id_materia'].')" type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i></button></td>
                </tr>';
        }
        $html_disponibles .= 
        '   </tbody>
        </table>';

       
        $respuesta = [
            'materias_asignadas' => $html_asignadas,
            'materias_disponibles' => $html_disponibles,
        ];
        return json_encode($respuesta);

    }

    public function actionGuardarmaterias()
    {   
        $datos = Yii::$app->request->post();
        $id_profesor = ArrayHelper::getValue($datos, 'id_profesor', 0);
        $materias_asignadas = ArrayHelper::getValue($datos, 'materias_asignadas', []);
       
        if($id_profesor > 0 && !empty($materias_asignadas)){
            $delete = ProfesorMateria::deleteAll(['id_profesor' => $id_profesor]);
            foreach ($materias_asignadas as $key => $asignada) {
                if($key > 0){
                    //inserta materias
                    $nueva_materia = new ProfesorMateria();
                    $nueva_materia->id_profesor = $id_profesor;
                    $nueva_materia->id_materia = $asignada;
                    $nueva_materia->fecha_alta = Yii::$app->formatter->asDate('now', 'php:Y-m-d H:i:s');
                    $nueva_materia->activo = 0;
                    $nueva_materia->save(false);
                }
            }
            $respuesta = [
                'code' => 200,
                'mensaje' => "Éxito",
            ];
        }else{
            $respuesta = [
                'code' => 422,
                'mensaje' => "Error",
            ];
        }

        return json_encode($respuesta);

    }

    /**
     * Deletes an existing Profesor model.
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
     * Finds the Profesor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Profesor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Profesor::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
