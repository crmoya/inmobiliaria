<?php

/**
 * This is the model class for table "mueble".
 *
 * The followings are the available columns in table 'mueble':
 * @property integer $id
 * @property string $nombre
 * @property string $fecha_compra
 * @property integer $departamento_id
 *
 * The followings are the available model relations:
 * @property Departamento $departamento
 */
class Mueble extends CActiveRecord
{
    
    public $departamento_num;
    public $propiedad_nom;
    public $propiedad_id;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mueble the static model class
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
		return 'mueble';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre, departamento_id', 'required'),
			array('departamento_id,propiedad_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>45),
			array('fecha_compra', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, departamento_num,propiedad_nom,nombre, fecha_compra, departamento_id', 'safe', 'on'=>'search'),
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
			'departamento' => array(self::BELONGS_TO, 'Departamento', 'departamento_id'),
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
			'fecha_compra' => 'Fecha Compra',
			'departamento_id' => 'Departamento',
                        'departamento_num' => 'N° Departamento',
                        'propiedad_nom' => 'Propiedad',
                        'propiedad_id' => 'Propiedad',
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
                $criteria->join = " join departamento on departamento.id = t.departamento_id "
                        . "         join propiedad on propiedad.id = departamento.propiedad_id"
                        . "         join contrato on contrato.departamento_id = t.departamento_id";
		$criteria->compare('id',$this->id);
		$criteria->compare('t.nombre',$this->nombre,true);
		$criteria->compare('fecha_compra',Tools::fixFecha($this->fecha_compra),true);
		$criteria->compare('t.departamento_id',$this->departamento_id);
                $criteria->compare('departamento.numero',$this->departamento_num,true);
                $criteria->compare('propiedad.nombre',$this->propiedad_nom,true);
                
                if(Yii::app()->user->rol == 'propietario'){
                    $criteriaPropietario = new CDbCriteria();
                    $contratos = Contrato::model()->relacionadosConPropietario(Yii::app()->user->id);
                    foreach($contratos as $contrato_id){
                        $criteriaPropietario->compare('contrato.id', $contrato_id, false,'OR');   
                    }
                    $criteria->mergeWith($criteriaPropietario,'AND');
                }
                
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
                            'attributes'=>array(
                                'propiedad_nom'=>array(
                                    'asc'=>'propiedad.nombre',
                                    'desc'=>'propiedad.nombre DESC',
                                ),
                                'departamento_num'=>array(
                                    'asc'=>'departamento.numero',
                                    'desc'=>'departamento.numero DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
        protected function gridDataColumn($data,$row)
	{
		return Tools::backFecha($data->fecha_compra);
	}
}