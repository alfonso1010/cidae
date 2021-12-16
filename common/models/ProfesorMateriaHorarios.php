<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profesor_materia_horarios".
 *
 * @property int $id
 * @property int $id_profesor_materia
 * @property int $id_profesor
 * @property int $id_materia
 * @property int $id_horario
 * @property int $id_grupo
 * @property string $dia_semana
 * @property string $hora_inicio
 * @property string $hora_fin
 *
 * @property Horarios $horario
 * @property ProfesorMateria $profesorMateria
 */
class ProfesorMateriaHorarios extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profesor_materia_horarios';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_profesor_materia', 'id_profesor', 'id_materia', 'id_horario', 'id_grupo', 'dia_semana', 'hora_inicio', 'hora_fin'], 'required'],
            [['id_profesor_materia', 'id_profesor', 'id_materia', 'id_horario', 'id_grupo'], 'integer'],
            [['dia_semana', 'hora_inicio', 'hora_fin'], 'string', 'max' => 45],
            [['id_horario', 'id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Horarios::className(), 'targetAttribute' => ['id_horario' => 'id_horario', 'id_grupo' => 'id_grupo']],
            [['id_profesor_materia', 'id_profesor', 'id_materia'], 'exist', 'skipOnError' => true, 'targetClass' => ProfesorMateria::className(), 'targetAttribute' => ['id_profesor_materia' => 'id_profesor_materia', 'id_profesor' => 'id_profesor', 'id_materia' => 'id_materia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_profesor_materia' => 'Id Profesor Materia',
            'id_profesor' => 'Id Profesor',
            'id_materia' => 'Id Materia',
            'id_horario' => 'Id Horario',
            'id_grupo' => 'Id Grupo',
            'dia_semana' => 'Dia Semana',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
        ];
    }

    /**
     * Gets query for [[Horario]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHorario()
    {
        return $this->hasOne(Horarios::className(), ['id_horario' => 'id_horario', 'id_grupo' => 'id_grupo']);
    }

    /**
     * Gets query for [[ProfesorMateria]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorMateria()
    {
        return $this->hasOne(ProfesorMateria::className(), ['id_profesor_materia' => 'id_profesor_materia', 'id_profesor' => 'id_profesor', 'id_materia' => 'id_materia']);
    }
}
