<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "profesor_materia".
 *
 * @property int $id_profesor_materia
 * @property int $id_profesor
 * @property int $id_materia
 * @property string $fecha_alta
 * @property int $activo
 *
 * @property AsistenciaAlumno[] $asistenciaAlumnos
 * @property CalificacionAlumno[] $calificacionAlumnos
 * @property Materias $materia
 * @property Profesor $profesor
 * @property ProfesorMateriaHorarios[] $profesorMateriaHorarios
 */
class ProfesorMateria extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profesor_materia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_profesor', 'id_materia', 'fecha_alta'], 'required'],
            [['id_profesor', 'id_materia', 'activo'], 'integer'],
            [['fecha_alta'], 'safe'],
            [['id_materia'], 'exist', 'skipOnError' => true, 'targetClass' => Materias::className(), 'targetAttribute' => ['id_materia' => 'id_materia']],
            [['id_profesor'], 'exist', 'skipOnError' => true, 'targetClass' => Profesor::className(), 'targetAttribute' => ['id_profesor' => 'id_profesor']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_profesor_materia' => 'Id Profesor Materia',
            'id_profesor' => 'Id Profesor',
            'id_materia' => 'Id Materia',
            'fecha_alta' => 'Fecha Alta',
            'activo' => 'Activo',
        ];
    }

    /**
     * Gets query for [[AsistenciaAlumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsistenciaAlumnos()
    {
        return $this->hasMany(AsistenciaAlumno::className(), ['id_profesor_materia' => 'id_profesor_materia', 'id_profesor' => 'id_profesor', 'id_materia' => 'id_materia']);
    }

    /**
     * Gets query for [[CalificacionAlumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionAlumnos()
    {
        return $this->hasMany(CalificacionAlumno::className(), ['id_profesor_materia' => 'id_profesor_materia', 'id_profesor' => 'id_profesor', 'id_materia' => 'id_materia']);
    }

    /**
     * Gets query for [[Materia]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMateria()
    {
        return $this->hasOne(Materias::className(), ['id_materia' => 'id_materia']);
    }

    /**
     * Gets query for [[Profesor]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfesor()
    {
        return $this->hasOne(Profesor::className(), ['id_profesor' => 'id_profesor']);
    }

    /**
     * Gets query for [[ProfesorMateriaHorarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorMateriaHorarios()
    {
        return $this->hasMany(ProfesorMateriaHorarios::className(), ['id_profesor_materia' => 'id_profesor_materia', 'id_profesor' => 'id_profesor', 'id_materia' => 'id_materia']);
    }
}
