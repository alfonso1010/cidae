<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "alumnos".
 *
 * @property int $id_alumno
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $direccion
 * @property string|null $telefono_casa
 * @property string $telefono_celular
 * @property string $sexo
 * @property string $email
 * @property string $matricula
 * @property int|null $edad
 * @property string|null $fecha_nacimiento
 * @property string $fecha_alta
 * @property int $activo
 * @property int $id_grupo
 *
 * @property Grupos $grupo
 * @property AsistenciaAlumno[] $asistenciaAlumnos
 * @property CalificacionAlumno[] $calificacionAlumnos
 */
class Alumnos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'alumnos';
    }

    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('now()'),
                'createdAtAttribute' => 'fecha_alta',
                'updatedAtAttribute' => 'fecha_alta',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido_paterno', 'apellido_materno', 'direccion', 'telefono_celular', 'sexo', 'email', 'matricula', 'id_grupo'], 'required'],
            [['direccion'], 'string'],
            [['edad', 'activo', 'id_grupo'], 'integer'],
            [['fecha_alta'], 'safe'],
            [['nombre', 'apellido_paterno'], 'string', 'max' => 60],
            [['apellido_materno', 'telefono_casa', 'telefono_celular', 'sexo', 'email', 'fecha_nacimiento'], 'string', 'max' => 45],
            [['matricula'], 'string', 'max' => 200],
            [['id_grupo'], 'exist', 'skipOnError' => true, 'targetClass' => Grupos::className(), 'targetAttribute' => ['id_grupo' => 'id_grupo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_alumno' => 'Id Alumno',
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'direccion' => 'Direccion',
            'telefono_casa' => 'Telefono Casa',
            'telefono_celular' => 'Telefono Celular',
            'sexo' => 'Sexo',
            'email' => 'Email',
            'matricula' => 'Matricula',
            'edad' => 'Edad',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'fecha_alta' => 'Fecha Alta',
            'activo' => 'Activo',
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

    /**
     * Gets query for [[AsistenciaAlumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAsistenciaAlumnos()
    {
        return $this->hasMany(AsistenciaAlumno::className(), ['id_alumno' => 'id_alumno']);
    }

    /**
     * Gets query for [[CalificacionAlumnos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCalificacionAlumnos()
    {
        return $this->hasMany(CalificacionAlumno::className(), ['id_alumno' => 'id_alumno']);
    }
}
