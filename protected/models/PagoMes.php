<?php

/**
 * This is the model class for table "pago_mes".
 *
 * The followings are the available columns in table 'pago_mes':
 * @property integer $id
 * @property integer $contrato_id
 * @property integer $monto_renta
 * @property integer $gasto_comun
 * @property integer $gasto_variable
 * @property integer $monto_mueble
 * @property string $fecha
 *
 * The followings are the available model relations:
 * @property Contrato $contrato
 */
class PagoMes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PagoMes the static model class
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
		return 'pago_mes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contrato_id, monto_renta, gasto_comun, gasto_variable, monto_mueble, fecha', 'required'),
			array('contrato_id, monto_renta, gasto_comun, gasto_variable, monto_mueble', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, contrato_id, monto_renta, gasto_comun, gasto_variable, monto_mueble, fecha', 'safe', 'on'=>'search'),
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
			'contrato' => array(self::BELONGS_TO, 'Contrato', 'contrato_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'contrato_id' => 'Contrato',
			'monto_renta' => 'Monto Renta',
			'gasto_comun' => 'Gasto Comun',
			'gasto_variable' => 'Gasto Variable',
			'monto_mueble' => 'Monto Mueble',
			'fecha' => 'Fecha',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('contrato_id',$this->contrato_id);
		$criteria->compare('monto_renta',$this->monto_renta);
		$criteria->compare('gasto_comun',$this->gasto_comun);
		$criteria->compare('gasto_variable',$this->gasto_variable);
		$criteria->compare('monto_mueble',$this->monto_mueble);
		$criteria->compare('fecha',$this->fecha,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function ultimoPago($contrato_id)
    {
        $ultimo = PagoMes::model()->find(array(
            "condition"=>"contrato_id = :contrato",
            "order"=>"fecha DESC",
            "limit"=>1,
            "params"=>array(":contrato"=>$contrato_id)
        ));
        
        return $ultimo;
    }
}