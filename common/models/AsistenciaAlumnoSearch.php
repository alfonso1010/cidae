<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AsistenciaAlumno;

/**
 * AsistenciaAlumnoSearch represents the model behind the search form of `common\models\AsistenciaAlumno`.
 */
class AsistenciaAlumnoSearch extends AsistenciaAlumno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_asistencia_alumno', 'asistio', 'id_alumno', 'id_materia', 'id_profesor', 'id_grupo', 'semestre', 'bloque'], 'integer'],
            [['fecha_asistencia', 'hora_asistencia', 'fecha_alta', 'nombre_materia', 'nombre_profesor','nombre_grupo'], 'safe'],
        ];
    }

       public function attributes()
    {
        return array_merge(parent::attributes(), [
            'nombre_grupo',
        ]);
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
        $query = AsistenciaAlumno::find();

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
            'id_asistencia_alumno' => $this->id_asistencia_alumno,
            'asistio' => $this->asistio,
            'fecha_asistencia' => $this->fecha_asistencia,
            'hora_asistencia' => $this->hora_asistencia,
            'fecha_alta' => $this->fecha_alta,
            'id_alumno' => $this->id_alumno,
            'id_materia' => $this->id_materia,
            'id_profesor' => $this->id_profesor,
            'id_grupo' => $this->id_grupo,
            'semestre' => $this->semestre,
            'bloque' => $this->bloque,
        ]);

        $query->andFilterWhere(['like', 'nombre_materia', $this->nombre_materia])
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
    public function searchAsistencias($params,$id_profesor)
    {
        $query = AsistenciaAlumno::find()
        ->select(['asistencia_alumno.*','grupos.nombre as nombre_grupo'])
        ->innerJoin('grupos', 
                    'asistencia_alumno.id_grupo = grupos.id_grupo')
        ->where(['asistencia_alumno.id_profesor' => $id_profesor])
        ->andWhere(['grupos.activo' => 0])
        ->orderBy(['asistencia_alumno.fecha_asistencia'=>SORT_DESC])
        ->groupBy(['fecha_asistencia','id_materia','id_profesor','id_grupo','semestre','bloque']);

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
            'id_asistencia_alumno' => $this->id_asistencia_alumno,
            'asistio' => $this->asistio,
            'fecha_asistencia' => $this->fecha_asistencia,
            'hora_asistencia' => $this->hora_asistencia,
            'fecha_alta' => $this->fecha_alta,
            'id_alumno' => $this->id_alumno,
            'id_materia' => $this->id_materia,
            'id_profesor' => $this->id_profesor,
            'id_grupo' => $this->id_grupo,
            'semestre' => $this->semestre,
            'bloque' => $this->bloque,
        ]);

        $query->andFilterWhere(['like', 'nombre_materia', $this->nombre_materia])
            ->andFilterWhere(['like', 'nombre_profesor', $this->nombre_profesor]);

        if($this->nombre_grupo != "" ){
            $query->andFilterWhere(['and',
                ['like', 'grupos.nombre',(!is_null($this->nombre_grupo))?$this->nombre_grupo:"%"],
             ]);
        }

        return $dataProvider;
    }
}
