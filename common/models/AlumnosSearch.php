<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Alumnos;

/**
 * AlumnosSearch represents the model behind the search form of `common\models\Alumnos`.
 */
class AlumnosSearch extends Alumnos
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_alumno', 'edad', 'activo', 'id_grupo'], 'integer'],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'direccion', 'telefono_casa', 'telefono_celular', 'sexo', 'email', 'matricula', 'fecha_nacimiento', 'fecha_alta'], 'safe'],
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
        $query = Alumnos::find();

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
            'edad' => $this->edad,
            'fecha_alta' => $this->fecha_alta,
            'activo' => $this->activo,
            'id_grupo' => $this->id_grupo,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido_paterno', $this->apellido_paterno])
            ->andFilterWhere(['like', 'apellido_materno', $this->apellido_materno])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono_casa', $this->telefono_casa])
            ->andFilterWhere(['like', 'telefono_celular', $this->telefono_celular])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'fecha_nacimiento', $this->fecha_nacimiento]);

        return $dataProvider;
    }
}
