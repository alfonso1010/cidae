<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "grupos".
 *
 * @property int $id_grupo
 * @property string $nombre
 * @property int $no_periodo
 * @property int|null $capacidad
 * @property int $id_carrera
 * @property int $no_evaluaciones_periodo
 * @property string $fecha_alta
 * @property int $activo
 *
 * @property AlumnosGrupos[] $alumnosGrupos
 * @property Carreras $carrera
 * @property Horarios[] $horarios
 * @property Materias[] $materias
 */
class Grupos extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'grupos';
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
            [['nombre', 'id_carrera','generacion','modalidad','fecha_inicio_clases'], 'required'],
            [['capacidad', 'id_carrera', 'no_evaluaciones_periodo', 'activo'], 'integer'],
            [['fecha_alta'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
            [['id_carrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carreras::className(), 'targetAttribute' => ['id_carrera' => 'id_carrera']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_grupo' => 'Id Grupo',
            'nombre' => 'Nombre',
            'generacion' => 'Generación',
            'modalidad' => 'Modalidad',
            'capacidad' => 'Capacidad',
            'id_carrera' => 'Id Carrera',
            'no_evaluaciones_periodo' => 'No Evaluaciones Periodo',
            'fecha_inicio_clases' => 'Fecha Inicio Clases',
            'fecha_alta' => 'Fecha Alta',
            'activo' => 'Activo',
        ];
    }

    /**
     * Gets query for [[AlumnosGrupos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumnosGrupos()
    {
        return $this->hasMany(AlumnosGrupos::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * Gets query for [[Carrera]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarrera()
    {
        return $this->hasOne(Carreras::className(), ['id_carrera' => 'id_carrera']);
    }

    /**
     * Gets query for [[Horarios]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getHorarios()
    {
        return $this->hasMany(Horarios::className(), ['id_grupo' => 'id_grupo']);
    }

    /**
     * Gets query for [[Materias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getMaterias()
    {
        return $this->hasMany(Materias::className(), ['id_grupo' => 'id_grupo']);
    }
}
