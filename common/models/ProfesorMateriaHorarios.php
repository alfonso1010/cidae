<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profesor_materia_horarios".
 *
 * @property int $id
 * @property int $id_horario
 * @property int $id_grupo
 * @property string $dia_semana
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property int $id_materia
 * @property int $id_profesor
 * @property string $nombre_materia
 * @property string $nombre_profesor
 *
 * @property Horarios $horario
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
            [['id_horario', 'id_grupo', 'dia_semana', 'hora_inicio', 'hora_fin', 'id_materia', 'id_profesor', 'nombre_materia', 'nombre_profesor'], 'required'],
            [['id_horario', 'id_grupo', 'id_materia', 'id_profesor'], 'integer'],
            [['dia_semana', 'hora_inicio', 'hora_fin'], 'string', 'max' => 45],
            [['nombre_materia', 'nombre_profesor'], 'string', 'max' => 255],
            [['id_horario', 'id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Horarios::className(), 'targetAttribute' => ['id_horario' => 'id_horario', 'id_grupo' => 'id_grupo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_horario' => 'Id Horario',
            'id_grupo' => 'Id Grupo',
            'dia_semana' => 'Dia Semana',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'id_materia' => 'Id Materia',
            'id_profesor' => 'Id Profesor',
            'nombre_materia' => 'Nombre Materia',
            'nombre_profesor' => 'Nombre Profesor',
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
}
