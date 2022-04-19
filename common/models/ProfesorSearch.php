<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Profesor;

/**
 * ProfesorSearch represents the model behind the search form of `common\models\Profesor`.
 */
class ProfesorSearch extends Profesor
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_profesor', 'activo', 'edad'], 'integer'],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'cedula', 'direccion', 'telefono_celular', 'telefono_casa', 'sexo', 'email', 'fecha_alta', 'fecha_nacimiento','matricula'], 'safe'],
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
        $query = Profesor::find();

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
            'id_profesor' => $this->id_profesor,
            'fecha_alta' => $this->fecha_alta,
            'activo' => $this->activo,
            'edad' => $this->edad,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido_paterno', $this->apellido_paterno])
            ->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'apellido_materno', $this->apellido_materno])
            ->andFilterWhere(['like', 'cedula', $this->cedula])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono_celular', $this->telefono_celular])
            ->andFilterWhere(['like', 'telefono_casa', $this->telefono_casa])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fecha_nacimiento', $this->fecha_nacimiento]);

        return $dataProvider;
    }
}
