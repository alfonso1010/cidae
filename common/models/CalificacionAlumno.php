<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "calificacion_alumno".
 *
 * @property int $id_calificacion_alumno
 * @property int $no_periodo
 * @property float $calificacion
 * @property int $no_evaluacion
 * @property string|null $observaciones
 * @property int $id_alumno
 * @property int $id_materia
 * @property int $id_profesor
 * @property string $nombre_materia
 * @property string $nombre_profesor
 *
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
            [['no_periodo', 'calificacion', 'no_evaluacion', 'id_alumno', 'id_materia', 'id_profesor', 'nombre_materia', 'nombre_profesor'], 'required'],
            [['no_periodo', 'no_evaluacion', 'id_alumno', 'id_materia', 'id_profesor'], 'integer'],
            [['calificacion'], 'number'],
            [['observaciones'], 'string'],
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
            'id_calificacion_alumno' => 'Id Calificacion Alumno',
            'no_periodo' => 'No Periodo',
            'calificacion' => 'Calificacion',
            'no_evaluacion' => 'No Evaluacion',
            'observaciones' => 'Observaciones',
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
