<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asistencia_alumno".
 *
 * @property int $id_asistencia_alumno
 * @property int $asistio
 * @property string $fecha_asistencia
 * @property string $hora_asistencia
 * @property string $fecha_alta
 * @property int $id_alumno
 * @property int $id_materia
 * @property int $id_profesor
 * @property string $nombre_materia
 * @property string $nombre_profesor
 *
 * @property Alumnos $alumno
 */
class AsistenciaAlumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asistencia_alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['asistio', 'fecha_asistencia', 'hora_asistencia', 'fecha_alta', 'id_alumno', 'id_materia', 'id_profesor', 'nombre_materia', 'nombre_profesor'], 'required'],
            [['asistio', 'id_alumno', 'id_materia', 'id_profesor'], 'integer'],
            [['fecha_asistencia', 'hora_asistencia', 'fecha_alta'], 'safe'],
            [['nombre_materia', 'nombre_profesor'], 'string', 'max' => 255],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['id_alumno' => 'id_alumno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_asistencia_alumno' => 'Id Asistencia Alumno',
            'asistio' => 'Asistio',
            'fecha_asistencia' => 'Fecha Asistencia',
            'hora_asistencia' => 'Hora Asistencia',
            'fecha_alta' => 'Fecha Alta',
            'id_alumno' => 'Id Alumno',
            'id_materia' => 'Id Materia',
            'id_profesor' => 'Id Profesor',
            'nombre_materia' => 'Nombre Materia',
            'nombre_profesor' => 'Nombre Profesor',
        ];
    }

    /**
     * Gets query for [[Alumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['id_alumno' => 'id_alumno']);
    }
}
