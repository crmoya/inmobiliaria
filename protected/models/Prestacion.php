<?php

/**
 * This is the model class for table "prestacion".
 *
 * The followings are the available columns in table 'prestacion':
 * @property integer $id
 * @property string $fecha
 * @property integer $monto
 * @property string $documento
 * @property string $descripcion
 * @property integer $tipo_prestacion_id
 * @property integer $ejecutor_id
 * @property integer $genera_cargos
 * @property integer $general_prop
 *
 * The followings are the available model relations:
 * @property TipoPrestacion $tipoPrestacion
 * @property Ejecutor $ejecutor
 * @property PrestacionADepartamento[] $prestacionADepartamentos
 */
class Prestacion extends CActiveRecord
{
    
    public $tipo_prestacion_nombre;
    public $ejecutor_nombre;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Prestacion the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        
        
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prestacion';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, monto, descripcion, tipo_prestacion_id, ejecutor_id, genera_cargos', 'required'),
			array('monto, tipo_prestacion_id, ejecutor_id, genera_cargos,propiedad_id', 'numerical', 'integerOnly'=>true),
			array('documento,general_prop', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha, monto, documento, descripcion, tipo_prestacion_nombre,ejecutor_nombre, tipo_prestacion_id, ejecutor_id, genera_cargos', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'tipoPrestacion' => array(self::BELONGS_TO, 'TipoPrestacion', 'tipo_prestacion_id'),
			'ejecutor' => array(self::BELONGS_TO, 'Ejecutor', 'ejecutor_id'),
			'prestacionADepartamentos' => array(self::HAS_MANY, 'PrestacionADepartamento', 'prestacion_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'monto' => 'Monto',
			'documento' => 'Documento',
			'descripcion' => 'Descripcion',
			'tipo_prestacion_id' => 'Tipo Prestación',
			'ejecutor_id' => 'Maestro',
			'genera_cargos' => 'Genera Cargos',
                        'tipo_prestacion_nombre' => 'Tipo Prestación',
                        'ejecutor_nombre' => 'Ejecutor',
                        'general_prop'=>'General Propiedad',
                        'propiedad_id'=>'Propiedad',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with=array('tipoPrestacion','ejecutor');
		$criteria->compare('id',$this->id);
		$criteria->compare('fecha',Tools::fixFecha($this->fecha),true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('tipo_prestacion_id',$this->tipo_prestacion_id);
		$criteria->compare('ejecutor_id',$this->ejecutor_id);
                if(Tools::fixGeneraCargos($this->genera_cargos) != ""){
                    $criteria->addCondition("genera_cargos = ".Tools::fixGeneraCargos($this->genera_cargos),'AND');
                }
                $criteria->compare('tipoPrestacion.nombre', $this->tipo_prestacion_nombre, true );
                $criteria->compare('ejecutor.nombre', $this->ejecutor_nombre, true );

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'tipo_prestacion_nombre'=>array(
                                    'asc'=>'tipoPrestacion.nombre',
                                    'desc'=>'tipoPrestacion.nombre DESC',
                                ),
                                'ejecutor_nombre'=>array(
                                    'asc'=>'ejecutor.nombre',
                                    'desc'=>'ejecutor.nombre DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
        protected function gridDataColumn($data,$row)
	{
		return Tools::backFecha($data->fecha);
	}
        
        protected function gridDataColumn2($data,$row)
	{
		return Tools::backGeneraCargos($data->genera_cargos);
	}
        
}