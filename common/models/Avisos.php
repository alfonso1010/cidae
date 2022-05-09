<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "avisos".
 *
 * @property int $id_aviso
 * @property string $nombre
 * @property string $ruta_aviso
 * @property string|null $imagen_portada
 * @property int $estatus
 * @property int|null $activo
 * @property string $fecha_inicio
 * @property string $fecha_fin
 */
class Avisos extends \yii\db\ActiveRecord
{

    const ACTIVO = 0;
    const PAUSADO = 1;

    public $file_aviso;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'avisos';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['ruta_aviso', 'imagen_portada'], 'string'],
            [['file_aviso'], 'required',  'on' => 'create','message'=>'Imagen de Aviso no puede estar vacía'],
            [['estatus', 'activo'], 'integer'],
            [['file_aviso'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['nombre'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_aviso' => 'Id Aviso',
            'nombre' => 'Nombre',
            'ruta_aviso' => 'Ruta Aviso',
            'imagen_portada' => 'Imagen Portada',
            'estatus' => 'Estatus',
            'activo' => 'Activo',
            'fecha_inicio' => 'Fecha Inicio',
            'fecha_fin' => 'Fecha Fin',
        ];
    }

    public function uploadPath() {
       
        $path = \Yii::getAlias('@webroot')."/avisos/";
        if(!file_exists($path)){
            mkdir($path,0777);
        }
        return $path;
    }

    public function uploadFiles() {
        if(!is_null($this->file_aviso)){
            $path_aviso = $this->uploadPath() ."aviso_". $this->nombre . "." .$this->file_aviso->extension;
            $this->file_aviso->saveAs($path_aviso, false);
            $this->ruta_aviso = "/avisos/aviso_".$this->nombre . "." .$this->file_aviso->extension;
        }
        
        return true;
    }   
}
