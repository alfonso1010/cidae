<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * This is the model class for table "formato_docentes".
 *
 * @property int $id
 * @property string $nombre
 * @property string $formato
 * @property string $fecha_alta
 */
class FormatoDocentes extends \yii\db\ActiveRecord
{

    public $file_formato;

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
    public static function tableName()
    {
        return 'formato_docentes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'file_formato'], 'required'],
            [['fecha_alta'], 'safe'],
            [['nombre', 'formato'], 'string', 'max' => 255],
            [['file_formato'], 'required',  'on' => 'create','message'=>'Formato no puede estar vacío'],
            [['file_formato'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'formato' => 'Formato',
            'fecha_alta' => 'Fecha Alta',
        ];
    }

    public function uploadPath() {
       
        $path = \Yii::getAlias('@webroot')."/formatos/docentes/";
        if(!file_exists($path)){
            mkdir($path,0777);
        }
        return $path;
    }

    public function uploadFiles() {
        if(!is_null($this->file_formato)){
            $path_formato = $this->uploadPath() ."formato_". $this->nombre . "." .$this->file_formato->extension;
            $this->file_formato->saveAs($path_formato, false);
            $this->formato = "/formatos/docentes/formato_".$this->nombre . "." .$this->file_formato->extension;
        }
        
        return true;
    }   

}
