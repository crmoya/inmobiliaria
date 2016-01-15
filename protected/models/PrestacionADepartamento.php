<?php

/**
 * This is the model class for table "prestacion_a_departamento".
 *
 * The followings are the available columns in table 'prestacion_a_departamento':
 * @property integer $prestacion_id
 * @property integer $departamento_id
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Prestacion $prestacion
 * @property Departamento $departamento
 */
class PrestacionADepartamento extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PrestacionADepartamento the static model class
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
		return 'prestacion_a_departamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('prestacion_id, departamento_id', 'required'),
			array('prestacion_id, departamento_id', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('prestacion_id, departamento_id, id', 'safe', 'on'=>'search'),
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
			'prestacion' => array(self::BELONGS_TO, 'Prestacion', 'prestacion_id'),
			'departamento' => array(self::BELONGS_TO, 'Departamento', 'departamento_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'prestacion_id' => 'Prestacion',
			'departamento_id' => 'Departamento',
			'id' => 'ID',
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

		$criteria->compare('prestacion_id',$this->prestacion_id);
		$criteria->compare('departamento_id',$this->departamento_id);
		$criteria->compare('id',$this->id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}