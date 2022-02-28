<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "pagos_alumno".
 *
 * @property int $id_pago_alumno
 * @property string $fecha_pago
 * @property string $monto_pago
 * @property string $concepto_pago
 * @property int $estatus_pago
 * @property int $tipo_pago
 * @property string $ruta_recibo
 * @property string $fecha_alta
 * @property string $fecha_actualizacion
 * @property int $id_alumno
 *
 * @property Alumnos $alumno
 */
class PagosAlumno extends \yii\db\ActiveRecord
{


    const PENDIENTE = 0;
    const APROBADO = 1;
    const DECLINADO = 2;


    public $file_recibo;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'pagos_alumno';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fecha_pago', 'monto_pago', 'concepto_pago', 'tipo_pago', 'id_alumno'], 'required'],
            [['fecha_pago', 'fecha_alta', 'fecha_actualizacion'], 'safe'],
            [['estatus_pago', 'tipo_pago', 'id_alumno'], 'integer'],
            [['ruta_recibo'], 'string'],
            [['file_recibo'], 'required', 'message'=>'Comprobante escaneado no puede estar vacío'],
            [['monto_pago'], 'string', 'max' => 45],
            [['concepto_pago'], 'string', 'max' => 255],
            [['id_alumno'], 'exist', 'skipOnError' => true, 'targetClass' => Alumnos::className(), 'targetAttribute' => ['id_alumno' => 'id_alumno']],
            [['file_recibo'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, pdf'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_pago_alumno' => 'Id Pago Alumno',
            'fecha_pago' => 'Fecha Pago',
            'monto_pago' => 'Monto Pago',
            'concepto_pago' => 'Concepto Pago',
            'estatus_pago' => 'Estatus Pago',
            'tipo_pago' => 'Tipo Pago',
            'ruta_recibo' => 'Ruta Recibo',
            'fecha_alta' => 'Fecha Alta',
            'fecha_actualizacion' => 'Fecha Actualizacion',
            'id_alumno' => 'Id Alumno',
        ];
    }


    public function uploadPath() {
        $path_a = \Yii::getAlias('@webroot')."/docs_alumnos/".$this->id_alumno;
        if(!file_exists($path_a)){
            mkdir($path_a,0777);
        }
        $path = \Yii::getAlias('@webroot')."/docs_alumnos/".$this->id_alumno."/pagos";
        if(!file_exists($path)){
            mkdir($path,0777);
        }
        return $path;
    }

    public function uploadFiles() {
        if(!is_null($this->file_recibo)){
            $path_recibo = $this->uploadPath() ."/recibo_". $this->fecha_pago . "." .$this->file_recibo->extension;
            $this->file_recibo->saveAs($path_recibo, false);
            $this->ruta_recibo = "/docs_alumnos/".$this->id_alumno."/pagos/recibo_".$this->fecha_pago . "." .$this->file_recibo->extension;
            $this->save();
        }
        
        return true;
    }   

    /**
     * Gets query for [[Alumno]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAlumno()
    {
        return $this->hasOne(Alumnos::className(), ['id_alumno' => 'id_alumno']);
    }
}
