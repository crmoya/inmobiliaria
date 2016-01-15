<?php

/**
 * This is the model class for table "tipo_contrato".
 *
 * The followings are the available columns in table 'tipo_contrato':
 * @property integer $id
 * @property string $nombre
 *
 * The followings are the available model relations:
 * @property Contrato[] $contratos
 */
class FormatoDemanda extends CActiveRecord
{
    
    public $documento;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return TipoContrato the static model class
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
		return 'formato_demanda';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre', 'required'),
			array('nombre', 'length', 'max'=>100),
                    array('documento', 'file', 'types'=>'docx', 'allowEmpty' => false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, nombre', 'safe', 'on'=>'search'),
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
			'demandas' => array(self::HAS_MANY, 'DemandaJudicial', 'formato_demanda_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
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
		$criteria->compare('nombre',$this->nombre,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * Entrega una lista con todos los tipos de contrato existentes
	 * @return CHtml::listData
	 */
	 public function getList()
	 {
	 	$formatos = FormatoDemanda::model()->findAll();
	    $listaFormatos = CHtml::listData($formatos, 'id', 'nombre');
	    return $listaFormatos;
	 }
}