<?php

/**
 * This is the model class for table "egreso".
 *
 * The followings are the available columns in table 'egreso':
 * @property integer $id
 * @property string $fecha
 * @property integer $monto
 * @property string $concepto
 * @property integer $respaldo
 * @property string $cta_contable
 * @property string $nro_cheque
 * @property integer $centro_costo_id
 * @property string $proveedor
 * @property string $nro_documento
 *
 * The followings are the available model relations:
 * @property CentroCosto $centroCosto
 */
class Egreso extends CActiveRecord
{
    public $propiedad_id;
    public $departamento_id;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'egreso';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, monto, concepto, respaldo, centro_costo_id', 'required'),
			array('monto, respaldo,propiedad_id,departamento_id, centro_costo_id', 'numerical', 'integerOnly'=>true),
			array('concepto', 'length', 'max'=>200),
			array('cta_contable, nro_cheque, proveedor, nro_documento', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha, monto, concepto, respaldo, cta_contable, nro_cheque, centro_costo_id, proveedor, nro_documento', 'safe', 'on'=>'search'),
		);
	}

        
        protected function gridDataColumn($data,$row)
	{
		return Tools::backFecha($data->fecha);
	}
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'centroCosto' => array(self::BELONGS_TO, 'CentroCosto', 'centro_costo_id'),
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
			'concepto' => 'Concepto',
			'respaldo' => 'Respaldo',
			'cta_contable' => 'Cuenta Contable',
			'nro_cheque' => 'N° Cheque',
			'centro_costo_id' => 'Centro de Costo',
			'proveedor' => 'Proveedor',
			'nro_documento' => 'N° Documento',
                        'propiedad_id' => 'Propiedad',
                        'departamento_id' => 'Departamento',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('centroCosto');

		$criteria->compare('id',$this->id);
		$criteria->compare('fecha',Tools::fixFecha($this->fecha),true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('concepto',$this->concepto,true);
		$criteria->compare('respaldo',$this->respaldo);
		$criteria->compare('cta_contable',$this->cta_contable,true);
		$criteria->compare('nro_cheque',$this->nro_cheque,true);
		$criteria->compare('centroCosto.nombre',$this->centro_costo_id,true);
		$criteria->compare('proveedor',$this->proveedor,true);
		$criteria->compare('nro_documento',$this->nro_documento,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'centro_costo_id'=>array(
                                    'asc'=>'centroCosto.nombre',
                                    'desc'=>'centroCosto.nombre DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Egreso the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
