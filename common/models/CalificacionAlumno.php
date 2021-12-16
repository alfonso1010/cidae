<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "calificacion_alumno".
 *
 * @property int $id_calificacion_alumno
 * @property int $id_profesor_materia
 * @property int $id_profesor
 * @property int $id_materia
 * @property int $no_periodo
 * @property float $calificacion
 * @property int $no_evaluacion
 * @property string|null $observaciones
 * @property int $id_alumno
 *
 * @property ProfesorMateria $profesorMateria
 * @property Alumnos $alumno
 */
class CalificacionAlumno extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'calificacion_alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_profesor_materia', 'id_profesor', 'id_materia', 'no_periodo', 'calificacion', 'no_evaluacion', 'id_alumno'], 'required'],
            [['id_profesor_materia', 'id_profesor', 'id_materia', 'no_periodo', 'no_evaluacion', 'id_alumno'], 'integer'],
            [['calificacion'], 'number'],
            [['observaciones'], 'string'],
            [['id_profesor_materia', 'id_profesor', 'id_materia'], 'exist', 'skipOnError' => true, 'targetClass' => ProfesorMateria::className(), 'targetAttribute' => ['id_profesor_materia' => 'id_profesor_materia', 'id_profesor' => 'id_profesor', 'id_materia' => 'id_materia']],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['id_alumno' => 'id_alumno']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_calificacion_alumno' => 'Id Calificacion Alumno',
            'id_profesor_materia' => 'Id Profesor Materia',
            'id_profesor' => 'Id Profesor',
            'id_materia' => 'Id Materia',
            'no_periodo' => 'No Periodo',
            'calificacion' => 'Calificacion',
            'no_evaluacion' => 'No Evaluacion',
            'observaciones' => 'Observaciones',
            'id_alumno' => 'Id Alumno',
        ];
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
