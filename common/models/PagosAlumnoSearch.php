<?php

namespace common\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\PagosAlumno;

/**
 * PagosAlumnoSearch represents the model behind the search form of `common\models\PagosAlumno`.
 */
class PagosAlumnoSearch extends PagosAlumno
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_pago_alumno', 'estatus_pago', 'tipo_pago', 'id_alumno'], 'integer'],
            [['fecha_pago', 'monto_pago', 'concepto_pago', 'ruta_recibo', 'fecha_alta', 'fecha_actualizacion'], 'safe'],
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
        $query = PagosAlumno::find();

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
            'id_pago_alumno' => $this->id_pago_alumno,
            'fecha_pago' => $this->fecha_pago,
            'estatus_pago' => $this->estatus_pago,
            'tipo_pago' => $this->tipo_pago,
            'fecha_alta' => $this->fecha_alta,
            'fecha_actualizacion' => $this->fecha_actualizacion,
            'id_alumno' => $this->id_alumno,
        ]);

        $query->andFilterWhere(['like', 'monto_pago', $this->monto_pago])
            ->andFilterWhere(['like', 'concepto_pago', $this->concepto_pago])
            ->andFilterWhere(['like', 'ruta_recibo', $this->ruta_recibo]);

        return $dataProvider;
    }

     /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchByAlumno($params,$id_alumno)
    {
        $query = PagosAlumno::find()->where(['id_alumno' => $id_alumno]);

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
            'id_pago_alumno' => $this->id_pago_alumno,
            'fecha_pago' => $this->fecha_pago,
            'estatus_pago' => $this->estatus_pago,
            'tipo_pago' => $this->tipo_pago,
            'fecha_alta' => $this->fecha_alta,
            'fecha_actualizacion' => $this->fecha_actualizacion,
            'id_alumno' => $this->id_alumno,
        ]);

        $query->andFilterWhere(['like', 'monto_pago', $this->monto_pago])
            ->andFilterWhere(['like', 'concepto_pago', $this->concepto_pago])
            ->andFilterWhere(['like', 'ruta_recibo', $this->ruta_recibo]);

        return $dataProvider;
    }
}
