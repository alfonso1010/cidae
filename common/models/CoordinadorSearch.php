<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Coordinador;

/**
 * CoordinadorSearch represents the model behind the search form of `common\models\Coordinador`.
 */
class CoordinadorSearch extends Coordinador
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_coordinador', 'activo', 'edad'], 'integer'],
            [['matricula', 'nombre', 'apellido_paterno', 'apellido_materno', 'cedula', 'direccion', 'telefono_celular', 'telefono_casa', 'sexo', 'email', 'fecha_alta', 'fecha_nacimiento', 'curp', 'rfc', 'nss', 'grado_academico', 'doc_acta_nacimiento', 'doc_curp', 'doc_ine', 'doc_comp_domicilio', 'doc_rfc', 'doc_nss', 'doc_titulo', 'doc_cedula', 'doc_curriculum'], 'safe'],
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
        $query = Coordinador::find();

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
            'id_coordinador' => $this->id_coordinador,
            'fecha_alta' => $this->fecha_alta,
            'activo' => $this->activo,
            'edad' => $this->edad,
        ]);

        $query->andFilterWhere(['like', 'matricula', $this->matricula])
            ->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido_paterno', $this->apellido_paterno])
            ->andFilterWhere(['like', 'apellido_materno', $this->apellido_materno])
            ->andFilterWhere(['like', 'cedula', $this->cedula])
            ->andFilterWhere(['like', 'direccion', $this->direccion])
            ->andFilterWhere(['like', 'telefono_celular', $this->telefono_celular])
            ->andFilterWhere(['like', 'telefono_casa', $this->telefono_casa])
            ->andFilterWhere(['like', 'sexo', $this->sexo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'fecha_nacimiento', $this->fecha_nacimiento])
            ->andFilterWhere(['like', 'curp', $this->curp])
            ->andFilterWhere(['like', 'rfc', $this->rfc])
            ->andFilterWhere(['like', 'nss', $this->nss])
            ->andFilterWhere(['like', 'grado_academico', $this->grado_academico])
            ->andFilterWhere(['like', 'doc_acta_nacimiento', $this->doc_acta_nacimiento])
            ->andFilterWhere(['like', 'doc_curp', $this->doc_curp])
            ->andFilterWhere(['like', 'doc_ine', $this->doc_ine])
            ->andFilterWhere(['like', 'doc_comp_domicilio', $this->doc_comp_domicilio])
            ->andFilterWhere(['like', 'doc_rfc', $this->doc_rfc])
            ->andFilterWhere(['like', 'doc_nss', $this->doc_nss])
            ->andFilterWhere(['like', 'doc_titulo', $this->doc_titulo])
            ->andFilterWhere(['like', 'doc_cedula', $this->doc_cedula])
            ->andFilterWhere(['like', 'doc_curriculum', $this->doc_curriculum]);

        return $dataProvider;
    }
}
