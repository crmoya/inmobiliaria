<?php

/**
 * This is the model class for table "debe_pagar".
 *
 * The followings are the available columns in table 'debe_pagar':
 * @property integer $id
 * @property integer $dia
 * @property integer $mes
 * @property integer $agno
 * @property integer $monto_renta
 * @property integer $monto_gastocomun
 * @property integer $monto_mueble
 * @property integer $monto_gastovariable
 * @property integer $contrato_id
 *
 * The followings are the available model relations:
 * @property Contrato $contrato
 */
class DebePagar extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DebePagar the static model class
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
		return 'debe_pagar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('dia, mes, agno, monto_renta, monto_gastocomun, monto_mueble, monto_gastovariable, contrato_id', 'required'),
			array('dia, mes, agno, monto_renta, monto_gastocomun, monto_mueble, monto_gastovariable, contrato_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, dia, mes, agno, monto_renta, monto_gastocomun, monto_mueble, monto_gastovariable, contrato_id', 'safe', 'on'=>'search'),
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
			'dia' => 'Desde Día',
			'mes' => 'Desde Mes',
			'agno' => 'Desde Año',
			'monto_renta' => 'Monto Renta',
			'monto_gastocomun' => 'Monto Gasto Común',
			'monto_mueble' => 'Monto Mueble',
			'monto_gastovariable' => 'Monto Gasto Variable',
			'contrato_id' => 'Contrato',
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
		$criteria->compare('dia',$this->dia);
		$criteria->compare('mes',$this->mes);
		$criteria->compare('agno',$this->agno);
		$criteria->compare('monto_renta',$this->monto_renta);
		$criteria->compare('monto_gastocomun',$this->monto_gastocomun);
		$criteria->compare('monto_mueble',$this->monto_mueble);
		$criteria->compare('monto_gastovariable',$this->monto_gastovariable);
                
                
		$criteria->compare('contrato_id',$this->contrato_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
    public function searchContrato($contrato_id)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('dia',$this->dia);
		$criteria->compare('mes',$this->mes);
		$criteria->compare('agno',$this->agno);
		$criteria->compare('monto_renta',$this->monto_renta);
		$criteria->compare('monto_gastocomun',$this->monto_gastocomun);
		$criteria->compare('monto_mueble',$this->monto_mueble);
		$criteria->compare('monto_gastovariable',$this->monto_gastovariable);
                
                
		$criteria->compare('contrato_id',$contrato_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function getCantidadAPagar($fecha, $contrato_id)
    {
        $debe_pagar = DebePagar::model()->findAll(array(
            'condition'=>'STR_TO_DATE(CONCAT(`agno`,"-",LPAD(`mes`,2,"00"),"-",LPAD(`dia`,2,"00")), "%Y-%m-%d") <= :fecha AND contrato_id = :contrato_id',
            'order'=>'STR_TO_DATE(CONCAT(`agno`,"-",LPAD(`mes`,2,"00"),"-",LPAD(`dia`,2,"00")), "%Y-%m-%d") DESC',
            'limit'=>1,
            'params'=>array(":fecha"=>$fecha, ":contrato_id"=>$contrato_id)
        ));
        if(empty($debe_pagar))
            return null;
        else
            return $debe_pagar[0];
    }
}