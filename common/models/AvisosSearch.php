<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Avisos;

/**
 * AvisosSearch represents the model behind the search form of `common\models\Avisos`.
 */
class AvisosSearch extends Avisos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_aviso', 'estatus', 'activo'], 'integer'],
            [['nombre', 'ruta_aviso', 'imagen_portada', 'fecha_inicio', 'fecha_fin'], 'safe'],
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
        $query = Avisos::find();

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
            'id_aviso' => $this->id_aviso,
            'estatus' => $this->estatus,
            'activo' => $this->activo,
            'fecha_inicio' => $this->fecha_inicio,
            'fecha_fin' => $this->fecha_fin,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'ruta_aviso', $this->ruta_aviso])
            ->andFilterWhere(['like', 'imagen_portada', $this->imagen_portada]);

        return $dataProvider;
    }
     public function searchAlumno($params)
    {
        $query = Avisos::find()
        ->andWhere(['estatus' => 0]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $dataProvider;
    }
}
