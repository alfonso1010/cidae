<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CalificacionAlumno;

/**
 * CalificacionAlumnoSearch represents the model behind the search form of `common\models\CalificacionAlumno`.
 */
class CalificacionAlumnoSearch extends CalificacionAlumno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_calificacion_alumno', 'no_evaluacion', 'id_alumno', 'id_materia', 'id_profesor', 'id_grupo', 'semestre', 'bloque', 'campo_editable'], 'integer'],
            [['calificacion'], 'number'],
            [['observaciones', 'fecha_alta', 'fecha_actualizacion', 'nombre_materia', 'nombre_profesor'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = CalificacionAlumno::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_calificacion_alumno' => $this->id_calificacion_alumno,
            'calificacion' => $this->calificacion,
            'no_evaluacion' => $this->no_evaluacion,
            'id_alumno' => $this->id_alumno,
            'id_materia' => $this->id_materia,
            'id_profesor' => $this->id_profesor,
            'id_grupo' => $this->id_grupo,
            'semestre' => $this->semestre,
            'bloque' => $this->bloque,
            'fecha_alta' => $this->fecha_alta,
            'fecha_actualizacion' => $this->fecha_actualizacion,
            'campo_editable' => $this->campo_editable,
        ]);

        $query->andFilterWhere(['like', 'observaciones', $this->observaciones])
            ->andFilterWhere(['like', 'nombre_materia', $this->nombre_materia])
            ->andFilterWhere(['like', 'nombre_profesor', $this->nombre_profesor]);

        return $dataProvider;
    }

     /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchCalificacionAlumnos($params,$id_grupo = 0,$semestre = 0,$bloque = 0)
    {
        if($id_grupo == 0){
            $query = CalificacionAlumno::find()->where(['id_grupo' => 0]);
            $dataProvider = new ActiveDataProvider([
                'query' => $query,
            ]);
            return $dataProvider;
        }
        $query = CalificacionAlumno::find()
        ->select(['calificacion_alumno.*','alumnos.nombre','alumnos.apellido_paterno','alumnos.apellido_materno','alumnos.matricula','grupos.nombre as nombre_grupo'])
        ->innerJoin('grupos', 
                    'calificacion_alumno.id_grupo = grupos.id_grupo')
        ->innerJoin('alumnos', 
                    'calificacion_alumno.id_alumno = alumnos.id_alumno');
        if($id_grupo > 0){
            $query = $query->andWhere(['calificacion_alumno.id_grupo' => $id_grupo]);
        }
        if($semestre > 0){
            $query = $query->andWhere(['calificacion_alumno.semestre' => $semestre]);
        }
        if($bloque > 0){
            $query = $query->andWhere(['calificacion_alumno.bloque' => $bloque]);
        }
        $query = $query
        ->andWhere(['alumnos.activo' => 0])
        ->andWhere(['grupos.activo' => 0])
        ->orderBy(['grupos.nombre'=>SORT_ASC])
        ->groupBy(['id_alumno','id_grupo','semestre','bloque']);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_alumno' => $this->id_alumno,
            'id_grupo' => $this->id_grupo,
            'semestre' => $this->semestre,
            'bloque' => $this->bloque,
            
        ]);


        return $dataProvider;
    }
}
