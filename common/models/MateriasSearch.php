<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Materias;

/**
 * MateriasSearch represents the model behind the search form of `common\models\Materias`.
 */
class MateriasSearch extends Materias
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_materia', 'periodo', 'id_carrera', 'activo'], 'integer'],
            [['nombre', 'clave', 'total_creditos','mes_periodo', 'fecha_alta'], 'safe'],
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
        $query = Materias::find();

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
        //print_r($params);die();

        // grid filtering conditions
        $query->andFilterWhere([
            'id_materia' => $this->id_materia,
            'periodo' => $this->periodo,
            'mes_periodo' => $this->mes_periodo,
            'id_carrera' => $this->id_carrera,
            'fecha_alta' => $this->fecha_alta,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'clave', $this->clave])
            ->andFilterWhere(['like', 'total_creditos', $this->total_creditos]);
        //print_r($query->createCommand()->getRawSql());die();

        return $dataProvider;
    }
}
