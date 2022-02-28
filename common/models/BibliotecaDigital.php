<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "biblioteca_digital".
 *
 * @property int $id_libro
 * @property int $categoria
 * @property string $nombre_libro
 * @property string $autor
 * @property string $editorial
 * @property string $ruta_libro
 * @property string|null $descripcion
 * @property int $estatus
 * @property int|null $activo
 * @property string $imagen_portada
 */
class BibliotecaDigital extends \yii\db\ActiveRecord
{

    public $file_libro;
    public $file_portada;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'biblioteca_digital';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre_libro', 'autor', 'editorial'], 'required'],
            [['categoria', 'estatus', 'activo'], 'integer'],
            [['file_libro'], 'required',  'on' => 'create','message'=>'Archivo de Libro Digital no puede estar vacío'],
            [['file_portada'], 'required', 'on' => 'create', 'message'=>'Portada del Libro no puede estar vacía'],
            [['ruta_libro', 'descripcion', 'imagen_portada'], 'string'],
            [['nombre_libro', 'autor', 'editorial'], 'string', 'max' => 255],
            [['file_portada'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
            [['file_libro'], 'file', 'skipOnEmpty' => true, 'extensions' => 'pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_libro' => 'Id Libro',
            'categoria' => 'Categoria',
            'nombre_libro' => 'Nombre Libro',
            'autor' => 'Autor',
            'editorial' => 'Editorial',
            'ruta_libro' => 'Ruta Libro',
            'descripcion' => 'Descripcion',
            'estatus' => 'Estatus',
            'activo' => 'Activo',
            'imagen_portada' => 'Imagen Portada',
        ];
    }


    public function uploadPath() {
       
        $path = \Yii::getAlias('@webroot')."/biblioteca/";
        if(!file_exists($path)){
            mkdir($path,0777);
        }
        return $path;
    }

    public function uploadFiles() {
        if(!is_null($this->file_libro)){
            $path_libro = $this->uploadPath() ."/libro_". $this->nombre_libro . "." .$this->file_libro->extension;
            $this->file_libro->saveAs($path_libro, false);
            $this->ruta_libro = "/biblioteca/libro_".$this->nombre_libro . "." .$this->file_libro->extension;
        }
         if(!is_null($this->file_portada)){
            $path_portada = $this->uploadPath() ."/portada_". $this->nombre_libro . "." .$this->file_portada->extension;
            $this->file_portada->saveAs($path_portada, false);
            $this->imagen_portada = "/biblioteca/portada_".$this->nombre_libro . "." .$this->file_portada->extension;
        }
        
        return true;
    }   

}
