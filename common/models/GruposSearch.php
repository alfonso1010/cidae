<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Grupos;

/**
 * GruposSearch represents the model behind the search form of `common\models\Grupos`.
 */
class GruposSearch extends Grupos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_grupo', 'capacidad', 'id_carrera', 'no_evaluaciones_periodo','generacion','modalidad','activo'], 'integer'],
            [['nombre', 'fecha_alta'], 'safe'],
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
        $query = Grupos::find();

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
            'id_grupo' => $this->id_grupo,
            'capacidad' => $this->capacidad,
            'id_carrera' => $this->id_carrera,
            'generacion' => $this->generacion,
            'modalidad' => $this->modalidad,
            'no_evaluaciones_periodo' => $this->no_evaluaciones_periodo,
            'fecha_alta' => $this->fecha_alta,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre]);

        return $dataProvider;
    }
}
