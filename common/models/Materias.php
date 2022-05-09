<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "materias".
 *
 * @property int $id_materia
 * @property string $nombre
 * @property string|null $clave
 * @property string|null $total_creditos
 * @property int $periodo
 * @property int $mes_periodo
 * @property int $id_carrera
 * @property string $fecha_alta
 * @property int $activo
 *
 * @property Carreras $carrera
 * @property ProfesorMateria[] $profesorMaterias
 */
class Materias extends \yii\db\ActiveRecord
{

    public $file_temario;


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'materias';
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
            [['nombre', 'periodo', 'mes_periodo', 'id_carrera'], 'required'],
            [['periodo', 'id_carrera', 'activo'], 'integer'],
            [['fecha_alta','mes_periodo','temario'], 'safe'],
            [['nombre'], 'string', 'max' => 255],
            [['clave'], 'string', 'max' => 100],
            [['total_creditos'], 'string', 'max' => 45],
            [['id_carrera'], 'exist', 'skipOnError' => true, 'targetClass' => Carreras::className(), 'targetAttribute' => ['id_carrera' => 'id_carrera']],
            [['file_temario'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf'],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_materia' => 'Id Materia',
            'nombre' => 'Nombre',
            'clave' => 'Clave',
            'total_creditos' => 'Total Creditos',
            'periodo' => 'Periodo',
            'mes_periodo' => 'Mes Periodo',
            'id_carrera' => 'Id Carrera',
            'fecha_alta' => 'Fecha Alta',
            'activo' => 'Activo',
        ];
    }

    public function uploadPath() {
       
        $path = \Yii::getAlias('@webroot')."/temarios/";
        if(!file_exists($path)){
            mkdir($path,0777);
        }
        return $path;
    }

    public function uploadFiles() {
        if(!is_null($this->file_temario)){
            $path_temario = $this->uploadPath(). $this->nombre . "." .$this->file_temario->extension;
            $this->file_temario->saveAs($path_temario, false);
            $this->temario = "/temarios/".$this->nombre . "." .$this->file_temario->extension;
        }
        
        return true;
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
     * Gets query for [[ProfesorMaterias]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProfesorMaterias()
    {
        return $this->hasMany(ProfesorMateria::className(), ['id_materia' => 'id_materia']);
    }
}
