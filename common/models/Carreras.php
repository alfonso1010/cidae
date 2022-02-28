<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "carreras".
 *
 * @property int $id_carrera
 * @property int $tipo_carrera
 * @property string $nombre
 * @property string $clave
 * @property string|null $rvoe
 * @property int $total_periodos
 * @property string $fecha_alta
 * @property int $activo
 *
 * @property Grupos[] $grupos
 */
class Carreras extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carreras';
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
            [['tipo_carrera', 'total_periodos', 'activo'], 'integer'],
            [['nombre', 'clave', 'total_periodos'], 'required'],
            [['fecha_alta'], 'safe'],
            [['nombre', 'clave', 'rvoe'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_carrera' => 'Id Carrera',
            'tipo_carrera' => 'Tipo Carrera',
            'nombre' => 'Nombre',
            'clave' => 'Clave',
            'rvoe' => 'Rvoe',
            'total_periodos' => 'Total Periodos',
            'fecha_alta' => 'Fecha Alta',
            'activo' => 'Activo',
        ];
    }

    /**
     * Gets query for [[Grupos]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getGrupos()
    {
        return $this->hasMany(Grupos::className(), ['id_carrera' => 'id_carrera']);
    }
}
