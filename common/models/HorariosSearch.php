<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Horarios;

/**
 * HorariosSearch represents the model behind the search form of `common\models\Horarios`.
 */
class HorariosSearch extends Horarios
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_horario', 'id_grupo'], 'integer'],
            [['turno'], 'safe'],
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
        $query = Horarios::find();

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
            'id_horario' => $this->id_horario,
            'id_grupo' => $this->id_grupo,
        ]);

        $query->andFilterWhere(['like', 'turno', $this->turno]);

        return $dataProvider;
    }
}
