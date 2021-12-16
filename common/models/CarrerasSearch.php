<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Carreras;

/**
 * CarrerasSearch represents the model behind the search form of `common\models\Carreras`.
 */
class CarrerasSearch extends Carreras
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_carrera', 'tipo_carrera', 'total_periodos', 'activo'], 'integer'],
            [['nombre', 'clave', 'rvoe', 'fecha_alta'], 'safe'],
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
        $query = Carreras::find();

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
            'id_carrera' => $this->id_carrera,
            'tipo_carrera' => $this->tipo_carrera,
            'total_periodos' => $this->total_periodos,
            'fecha_alta' => $this->fecha_alta,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'rvoe', $this->rvoe]);

        return $dataProvider;
    }
}
