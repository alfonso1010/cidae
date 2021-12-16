<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "horarios".
 *
 * @property int $id_horario
 * @property int $id_grupo
 * @property string $turno
 *
 * @property Grupos $grupo
 * @property ProfesorMateriaHorarios[] $profesorMateriaHorarios
 */
class Horarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_grupo', 'turno'], 'required'],
            [['id_grupo'], 'integer'],
            [['turno'], 'string', 'max' => 45],
            [['id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['id_grupo' => 'id_grupo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_horario' => 'Id Horario',
            'id_grupo' => 'Id Grupo',
            'turno' => 'Turno',
        ];
    }

    /**
     * Gets query for [[Grupo]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupo()
    {
        return $this->hasOne(Grupos::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * Gets query for [[ProfesorMateriaHorarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorMateriaHorarios()
    {
        return $this->hasMany(ProfesorMateriaHorarios::className(), ['id_horario' => 'id_horario', 'id_grupo' => 'id_grupo']);
    }
}
