<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\BibliotecaDigital;

/**
 * BibliotecaDigitalSearch represents the model behind the search form of `common\models\BibliotecaDigital`.
 */
class BibliotecaDigitalSearch extends BibliotecaDigital
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_libro', 'categoria', 'estatus', 'activo'], 'integer'],
            [['nombre_libro', 'autor', 'editorial', 'ruta_libro', 'descripcion', 'imagen_portada'], 'safe'],
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
        $query = BibliotecaDigital::find();

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
            'id_libro' => $this->id_libro,
            'categoria' => $this->categoria,
            'estatus' => $this->estatus,
            'activo' => $this->activo,
        ]);

        $query->andFilterWhere(['like', 'nombre_libro', $this->nombre_libro])
            ->andFilterWhere(['like', 'autor', $this->autor])
            ->andFilterWhere(['like', 'editorial', $this->editorial])
            ->andFilterWhere(['like', 'ruta_libro', $this->ruta_libro])
            ->andFilterWhere(['like', 'descripcion', $this->descripcion])
            ->andFilterWhere(['like', 'imagen_portada', $this->imagen_portada]);

        return $dataProvider;
    }

     public function searchByName($params,$nombre)
    {
        $query = BibliotecaDigital::find()->where(['like', 'nombre_libro', "%".$nombre. '%', false]);
        //print_r($query->createCommand()->getRawSql());die();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);


        return $dataProvider;
    }
}
