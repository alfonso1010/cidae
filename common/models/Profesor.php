<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "profesor".
 *
 * @property int $id_profesor
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $cedula
 * @property string|null $direccion
 * @property string $telefono_celular
 * @property string|null $telefono_casa
 * @property string $sexo
 * @property string|null $email
 * @property string $fecha_alta
 * @property int $activo
 * @property int|null $edad
 * @property string|null $fecha_nacimiento
 *
 * @property ProfesorMateria[] $profesorMaterias
 */
class Profesor extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'profesor';
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
            [['nombre', 'apellido_paterno', 'apellido_materno', 'cedula', 'telefono_celular', 'sexo','curp','rfc','nss','banco','clabe_interbancaria','grado_academico','email'], 'required'],
            [['direccion','no_cuenta','no_tarjeta'], 'string'],
            [['fecha_alta'], 'safe'],
            [['activo', 'edad'], 'integer'],
            [['nombre', 'apellido_paterno', 'apellido_materno', 'telefono_celular', 'telefono_casa', 'fecha_nacimiento'], 'string', 'max' => 45],
            [['cedula', 'email'], 'string', 'max' => 100],
            [['sexo'], 'string', 'max' => 10],
            [['curp'], 'string', 'max' => 18],
            [['curp'], 'string', 'min' => 18],
            [['rfc'], 'string', 'max' => 13],
            [['rfc'], 'string', 'min' => 13],
            [['telefono_casa'], 'string', 'max' => 10],
            [['telefono_casa'], 'string', 'min' => 10],
            [['telefono_celular'], 'string', 'max' => 10],
            [['telefono_celular'], 'string', 'min' => 10],
            [['telefono_contacto_emergencia'], 'string', 'max' => 10],
            [['telefono_contacto_emergencia'], 'string', 'min' => 10],
            [['clabe_interbancaria'], 'string', 'min' => 18],
            [['clabe_interbancaria'], 'string', 'max' => 18],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_profesor' => 'Id Profesor',
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'cedula' => 'Cedula',
            'direccion' => 'Direccion',
            'telefono_celular' => 'Telefono Celular',
            'telefono_casa' => 'Telefono Casa',
            'sexo' => 'Sexo',
            'email' => 'Email',
            'fecha_alta' => 'Fecha Alta',
            'activo' => 'Activo',
            'edad' => 'Edad',
            'fecha_nacimiento' => 'Fecha Nacimiento',
            'curp' => 'CURP',
            'rfc' => 'RFC',
            'nss' => 'NSS',
            'banco' => 'BANCO',
            'no_cuenta' => 'No. Cuenta',
            'clabe_interbancaria' => 'Clabe Interbancaria',
            'no_tarjeta' => 'No. tarjeta',
            'grado_academico' => 'Grado Académico',
        ];
    }

     /**
     * Funcion que concatena el nombre completo del alumno
     * @return String Nombre completo del cliente
     */
    public function getNombreCompleto() {
        return $this->nombre.' '
        .$this->apellido_paterno.' '
        .$this->apellido_materno;
    }

    /**
     * Gets query for [[ProfesorMaterias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorMaterias()
    {
        return $this->hasMany(ProfesorMateria::className(), ['id_profesor' => 'id_profesor']);
    }
}
