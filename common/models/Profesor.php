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
    public $file_acta;
    public $file_curp;
    public $file_ine;
    public $file_comp_domi;
    public $file_rfc;
    public $file_nss;
    public $file_titulo;
    public $file_cedula;
    public $file_cv;
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
            [['direccion','no_cuenta','no_tarjeta','doc_acta_nacimiento','doc_curp','doc_ine','doc_comp_domicilio','doc_rfc','doc_nss','doc_titulo','doc_cedula','doc_curriculum'], 'string'],
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
            [['clabe_interbancaria'], 'string', 'min' => 18],
            [['clabe_interbancaria'], 'string', 'max' => 18],
            [['file_acta','file_curp','file_ine','file_comp_domi','file_rfc','file_nss','file_titulo','file_cedula','file_cv'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf'],
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
            "doc_acta_nacimiento" => 'Acta Nacimiento',
            "doc_curp" => 'Doc CURP',
            "doc_ine" => 'INE',
            "doc_comp_domicilio" => 'Comp. Domicilio',
            "doc_rfc" => 'Doc. RFC',
            "doc_nss" => 'Doc. NSS',
            "doc_cedula" => 'Doc. CÉDULA',
            "doc_titulo" => 'Doc. TÍTULO',
            "doc_curriculum" => 'Doc. CV',
        ];
    }

    public function uploadPath() {
        $path = \Yii::getAlias('@webroot')."/docs_docentes/".$this->id_profesor."/";
        if(!file_exists($path)){
            mkdir($path,0777);
        }
        if (!file_exists($path."index.html") ){ 
            $fp = fopen($path."index.html","w+"); 
        }
        return $path;
    }

    public function uploadFiles() {
        if(!is_null($this->file_acta)){
            $path_acta = $this->uploadPath() ."acta_". $this->id_profesor . "." .$this->file_acta->extension;
            $this->file_acta->saveAs($path_acta, false);
            $this->doc_acta_nacimiento = "acta_".$this->id_profesor . "." .$this->file_acta->extension;
            $this->save();
        }
        if(!is_null($this->file_curp)){
            $path_curp = $this->uploadPath() . "curp_".$this->id_profesor . "." .$this->file_curp->extension;
            $this->file_curp->saveAs($path_curp, false);
            $this->doc_curp = "curp_".$this->id_profesor . "." .$this->file_curp->extension;
            $this->save();
        }
        if(!is_null($this->file_ine)){
            $path_ine = $this->uploadPath() . "ine_".$this->id_profesor . "." .$this->file_ine->extension;
            $this->file_ine->saveAs($path_ine, false);
            $this->doc_ine = "ine_".$this->id_profesor . "." .$this->file_ine->extension;
            $this->save();
        }
        if(!is_null($this->file_comp_domi)){
            $path_comp = $this->uploadPath() . "comp_domi_".$this->id_profesor . "." .$this->file_comp_domi->extension;
            $this->file_comp_domi->saveAs($path_comp, false);
            $this->doc_comp_domicilio = "comp_domi_".$this->id_profesor . "." .$this->file_comp_domi->extension;
            $this->save();
        }
        if(!is_null($this->file_rfc)){
            $path_rfc = $this->uploadPath() . "rfc_".$this->id_profesor . "." .$this->file_rfc->extension;
            $this->file_rfc->saveAs($path_rfc, false);
            $this->doc_rfc = "rfc_".$this->id_profesor . "." .$this->file_rfc->extension;
            $this->save();
        }
        if(!is_null($this->file_nss)){
            $path_nss = $this->uploadPath() . "nss_".$this->id_profesor . "." .$this->file_nss->extension;
            $this->file_nss->saveAs($path_nss, false);
            $this->doc_nss = "nss_".$this->id_profesor . "." .$this->file_nss->extension;
            $this->save();
        }
        if(!is_null($this->file_cedula)){
            $path_cedula = $this->uploadPath() . "cedula_".$this->id_profesor . "." .$this->file_cedula->extension;
            $this->file_cedula->saveAs($path_cedula, false);
            $this->doc_cedula = "cedula_".$this->id_profesor . "." .$this->file_cedula->extension;
            $this->save();
        }
        if(!is_null($this->file_titulo)){
            $path_titulo = $this->uploadPath() . "titulo_".$this->id_profesor . "." .$this->file_titulo->extension;
            $this->file_titulo->saveAs($path_titulo, false);
            $this->doc_titulo = "titulo_".$this->id_profesor . "." .$this->file_titulo->extension;
            $this->save();
        }
        if(!is_null($this->file_cv)){
            $path_cv = $this->uploadPath() . "cv_".$this->id_profesor . "." .$this->file_cv->extension;
            $this->file_cv->saveAs($path_cv, false);
            $this->doc_curriculum = "cv_".$this->id_profesor . "." .$this->file_cv->extension;
            $this->save();
        }
        return true;
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
