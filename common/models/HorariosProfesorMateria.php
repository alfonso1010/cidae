<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "horarios_profesor_materia".
 *
 * @property int $id
 * @property string $dia_semana
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property int $id_materia
 * @property int $id_profesor
 * @property string $nombre_materia
 * @property string $nombre_profesor
 * @property int $id_grupo
 *
 * @property Grupos $grupo
 */
class HorariosProfesorMateria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'horarios_profesor_materia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['dia_semana', 'hora_inicio', 'hora_fin', 'id_materia', 'id_profesor', 'nombre_materia', 'nombre_profesor', 'id_grupo','semestre'], 'required'],
            [['id_materia', 'id_profesor', 'id_grupo'], 'integer'],
            [['dia_semana', 'hora_inicio', 'hora_fin'], 'string', 'max' => 45],
            [['nombre_materia', 'nombre_profesor'], 'string', 'max' => 255],
            [['id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['id_grupo' => 'id_grupo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia_semana' => 'Dia Semana',
            'hora_inicio' => 'Hora Inicio',
            'hora_fin' => 'Hora Fin',
            'id_materia' => 'Id Materia',
            'id_profesor' => 'Id Profesor',
            'nombre_materia' => 'Nombre Materia',
            'nombre_profesor' => 'Nombre Profesor',
            'semestre' => 'Semestre',
            'id_grupo' => 'Id Grupo',
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
}
