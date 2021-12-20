<?php

namespace backend\controllers;

use Yii;
use common\models\HorariosProfesorMateria;
use common\models\Carreras;
use common\models\Grupos;
use common\models\Profesor;
use common\models\ProfesorMateria;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
        $lista_carreras = Carreras::find()->select(["id_carrera",'nombre'])->where(['activo' => 0])->asArray()->all();
        $carreras = ArrayHelper::map($lista_carreras, 'id_carrera', 'nombre');
        return $this->render('horarios', [
            'carreras' => $carreras,
        ]);
    }

     /**
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionBuscagrupos($id)
    {
        $grupos = Grupos::find()->select(["id_grupo",'nombre'])->where(['id_carrera' => $id,'activo' => 0])->all();
        echo "<option value=''>Seleccione Grupo ...</option>";
        if(!empty($grupos)){
            foreach ($grupos as $key => $grupo) {
                echo "<option value='".$grupo->id_grupo."'>".$grupo->nombre."</option>";
            }
        }else{
            echo "<option value=''> No hay grupos ...</option>";
        }
    }

    /**
     * Lists all Horarios models.
     * @return mixed
     */
    public function actionCargarhorarios()
    {
        $datos = Yii::$app->request->post();
        $id_grupo = ArrayHelper::getValue($datos, 'id_grupo', 0);
        $id_carrera = ArrayHelper::getValue($datos, 'id_carrera', 0);
        if($id_carrera > 0 && $id_grupo > 0){
            $profesores = Profesor::find()->select(["profesor.id_profesor",'concat(profesor.nombre, " ", profesor.apellido_paterno, " ", profesor.apellido_materno) as nombre_completo',"materias.nombre as nombre_materia","materias.id_materia"])
                ->innerJoin( 'profesor_materia','profesor.id_profesor = profesor_materia.id_profesor')
                ->innerJoin( 'materias','profesor_materia.id_materia = materias.id_materia')
                ->where(["materias.id_carrera" => $id_carrera])
                ->asArray()->all();
            if(!empty($profesores)){
                $select_prof = "
                    <option value='0'> Seleccione </option>
                    <option value='libre'> Hora Libre </option>
                ";
                foreach ($profesores as $key => $profesor) {
                    $select_prof .= '
                    <option value="'.$profesor['id_profesor'].'-'.$profesor['id_materia'].'"> 
                        '.$profesor['nombre_completo'].' - '.$profesor['nombre_materia'].'
                    </option>
                   '; 
                }
                $tabla = '
                <table class="table table-responsive">
                    <tbody>
                        <tr>
                            <th>Hora</th>
                            <th>Lunes</th>
                            <th>Martes</th>
                            <th>Miércoles</th>
                            <th>Jueves</th>
                            <th>Viernes</th>
                            <th>Sábado</th>
                        </tr>';
                    for ($i=8; $i < 20; $i++) {
                        $hora_fin = $i+1; 
                        $tabla .= "
                        <tr>
                            <td width='120px'> 
                                <b style='color: #092f87' >".$i.":00 - ".$hora_fin.":00</b>
                            </td>
                            <td>
                                <select data-dia='1' data-hora_inicio='".$i."' data-hora_fin='".$hora_fin."' class='form-control'>
                                    ".$select_prof."
                                </select>
                            </td>
                            <td>
                                <select data-dia='2' data-hora_inicio='".$i."' data-hora_fin='".$hora_fin."' class='form-control'>
                                    ".$select_prof."
                                </select>
                            </td>
                            <td>
                                <select data-dia='3' data-hora_inicio='".$i."' data-hora_fin='".$hora_fin."' class='form-control'>
                                    ".$select_prof."
                                </select>
                            </td>
                            <td>
                                <select data-dia='4' data-hora_inicio='".$i."' data-hora_fin='".$hora_fin."' class='form-control'>
                                    ".$select_prof."
                                </select>
                            </td>
                            <td>
                                <select data-dia='5' data-hora_inicio='".$i."' data-hora_fin='".$hora_fin."' class='form-control'>
                                    ".$select_prof."
                                </select>
                            </td>
                            <td>
                                <select data-dia='6' data-hora_inicio='".$i."' data-hora_fin='".$hora_fin."' class='form-control'>
                                    ".$select_prof."
                                </select>
                            </td>
                          
                        </tr>
                        ";                       
                    }
                    
                $tabla .= "
                    </tbody>
                </table>";
                $data = [
                    "code" => 200,
                    "tabla" => $tabla,
                    "mensaje" => "Éxito",
                ];
            }else{
                $data = [
                    "code" => 422,
                    "tabla" => "",
                    "mensaje" => "No existen profesores asignados a las materias de la carrera seleccionada",
                ];
            }
        }else{
            $data = [
                "code" => 201,
                "tabla" => ""
            ];
        }
        
        return json_encode($data);
    }

   
}
