<?php

/**
 * This is the model class for table "movimiento".
 *
 * The followings are the available columns in table 'movimiento':
 * @property integer $id
 * @property string $fecha
 * @property string $tipo
 * @property integer $monto
 * @property string $detalle
 * @property integer $validado
 * @property integer $cuenta_corriente_id
 * @property string $forma_pago
 *
 * The followings are the available model relations:
 * @property CuentaCorriente $cuentaCorriente
 */
class Movimiento extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'movimiento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, tipo, monto, detalle, validado, cuenta_corriente_id', 'required'),
			array('monto, validado, cuenta_corriente_id', 'numerical', 'integerOnly'=>true),
			array('detalle', 'length', 'max'=>200),
			array('forma_pago', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha, tipo, monto, detalle, validado, cuenta_corriente_id, forma_pago', 'safe', 'on'=>'search'),
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
			'cuentaCorriente' => array(self::BELONGS_TO, 'CuentaCorriente', 'cuenta_corriente_id'),
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
			'tipo' => 'Tipo',
			'monto' => 'Monto',
			'detalle' => 'Detalle',
			'validado' => 'Validado',
			'cuenta_corriente_id' => 'Cuenta Corriente',
			'forma_pago' => 'Forma Pago',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('tipo',$this->tipo);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('detalle',$this->detalle,true);
		$criteria->compare('validado',$this->validado);
		$criteria->compare('cuenta_corriente_id',$this->cuenta_corriente_id);
		$criteria->compare('forma_pago',$this->forma_pago,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTypeMovOptions(){
            return CHtml::listData(
                    array(
                        array('tipo'=>  Tools::MOVIMIENTO_TIPO_ABONO),
                        array('tipo'=>  Tools::MOVIMIENTO_TIPO_CARGO)
                    ),'tipo','tipo');
        }

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Movimiento the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
