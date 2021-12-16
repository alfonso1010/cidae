<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "asistencia_alumno".
 *
 * @property int $id_asistencia_alumno
 * @property int $id_profesor_materia
 * @property int $id_profesor
 * @property int $id_materia
 * @property int $asistio
 * @property string $fecha_asistencia
 * @property string $hora_asistencia
 * @property string $fecha_alta
 * @property int $id_alumno
 *
 * @property Alumnos $alumno
 * @property ProfesorMateria $profesorMateria
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
            [['id_profesor_materia', 'id_profesor', 'id_materia', 'asistio', 'fecha_asistencia', 'hora_asistencia', 'fecha_alta', 'id_alumno'], 'required'],
            [['id_profesor_materia', 'id_profesor', 'id_materia', 'asistio', 'id_alumno'], 'integer'],
            [['fecha_asistencia', 'hora_asistencia', 'fecha_alta'], 'safe'],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['id_alumno' => 'id_alumno']],
            [['id_profesor_materia', 'id_profesor', 'id_materia'], 'exist', 'skipOnError' => true, 'targetClass' => ProfesorMateria::className(), 'targetAttribute' => ['id_profesor_materia' => 'id_profesor_materia', 'id_profesor' => 'id_profesor', 'id_materia' => 'id_materia']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_asistencia_alumno' => 'Id Asistencia Alumno',
            'id_profesor_materia' => 'Id Profesor Materia',
            'id_profesor' => 'Id Profesor',
            'id_materia' => 'Id Materia',
            'asistio' => 'Asistio',
            'fecha_asistencia' => 'Fecha Asistencia',
            'hora_asistencia' => 'Hora Asistencia',
            'fecha_alta' => 'Fecha Alta',
            'id_alumno' => 'Id Alumno',
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
