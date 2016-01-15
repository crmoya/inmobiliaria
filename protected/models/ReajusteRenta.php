<?php

/**
 * This is the model class for table "reajuste_renta".
 *
 * The followings are the available columns in table 'reajuste_renta':
 * @property integer $id
 * @property string $fecha_desde
 * @property double $porcentaje
 */
class ReajusteRenta extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ReajusteRenta the static model class
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
		return 'reajuste_renta';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha_desde, porcentaje', 'required'),
			array('porcentaje', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, fecha_desde, porcentaje', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha_desde' => 'Aplica Desde',
			'porcentaje' => 'Porcentaje',
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
		$criteria->compare('fecha_desde',Tools::fixFecha($this->fecha_desde),true);
		$criteria->compare('porcentaje',$this->porcentaje);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function gridDataColumn($data,$row)
	{
		return Tools::backFecha($data->fecha_desde);
	}
}