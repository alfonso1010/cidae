<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\HorariosProfesorMateria;

/**
 * HorariosProfesorMateriaSearch represents the model behind the search form of `common\models\HorariosProfesorMateria`.
 */
class HorariosProfesorMateriaSearch extends HorariosProfesorMateria
{

     public function attributes()
    {
        return array_merge(parent::attributes(), [
            'nombre_grupo',
        ]);
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_materia', 'id_profesor', 'semestre', 'id_grupo'], 'integer'],
            [['dia_semana', 'hora_inicio', 'hora_fin', 'nombre_materia', 'nombre_profesor','nombre_grupo'], 'safe'],
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
        $query = HorariosProfesorMateria::find();

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
            'id' => $this->id,
            'id_materia' => $this->id_materia,
            'id_profesor' => $this->id_profesor,
            'semestre' => $this->semestre,
            'id_grupo' => $this->id_grupo,
        ]);

        $query->andFilterWhere(['like', 'dia_semana', $this->dia_semana])
            ->andFilterWhere(['like', 'hora_inicio', $this->hora_inicio])
            ->andFilterWhere(['like', 'hora_fin', $this->hora_fin])
            ->andFilterWhere(['like', 'nombre_materia', $this->nombre_materia])
            ->andFilterWhere(['like', 'nombre_profesor', $this->nombre_profesor]);

        return $dataProvider;
    }

    //obtiene los grupos asignados a un profesor
      /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchGruposProfesor($params,$id_profesor)
    {
        $query = HorariosProfesorMateria::find()
            ->select(['horarios_profesor_materia.*','grupos.nombre as nombre_grupo'])
            ->innerJoin('grupos', 
                    'horarios_profesor_materia.id_grupo = grupos.id_grupo')
            ->where(['horarios_profesor_materia.id_profesor' => $id_profesor])
            ->groupBy(['horarios_profesor_materia.id_materia'])
            ->orderBy(['horarios_profesor_materia.id_grupo'=>SORT_ASC]);

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

        if($this->nombre_grupo != "" | $this->nombre_materia != ""){
            $query->andFilterWhere(['and',
                ['like', 'grupos.nombre',(!is_null($this->nombre_grupo))?$this->nombre_grupo:"%"],
                ['like', 'horarios_profesor_materia.nombre_materia',(!is_null($this->nombre_materia))?$this->nombre_materia:"%"],
             ]);
        }
       // print_r($query->createCommand()->sql);die();

        return $dataProvider;
    }
}
