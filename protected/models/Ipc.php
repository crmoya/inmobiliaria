<?php

/**
 * This is the model class for table "ipc".
 *
 * The followings are the available columns in table 'ipc':
 * @property integer $id
 * @property double $porcentaje
 * @property integer $mes
 * @property integer $agno
 */
class Ipc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ipc the static model class
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
		return 'ipc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('porcentaje, mes, agno', 'required'),
			array('porcentaje', 'numerical'),
                        array('mes,agno', 'numerical','integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, porcentaje, mes, agno', 'safe', 'on'=>'search'),
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
			'porcentaje' => 'IPC del Mes',
			'mes' => 'Mes',
                        'agno' => 'Año',
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
                $criteria->compare('mes',$this->mes);
                $criteria->compare('id',$this->id);
		$criteria->compare('porcentaje',$this->porcentaje);
		$criteria->compare('agno',$this->agno);
                $criteria->order = 'agno desc,mes desc';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
}