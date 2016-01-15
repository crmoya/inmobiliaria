<?php

/**
 * This is the model class for table "contrato_mueble".
 *
 * The followings are the available columns in table 'contrato_mueble':
 * @property integer $id
 * @property integer $contrato_id
 * @property integer $monto
 * @property date $fecha_inicio
 *
 * The followings are the available model relations:
 * @property Contrato $contrato
 */
class ContratoMueble extends CActiveRecord
{
    
    public $folio;
    public $depto_nombre;
    public $propiedad_nombre;
    public $cliente_nombre;
    public $cliente_rut;
    public $imagen;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ContratoMueble the static model class
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
		return 'contrato_mueble';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('contrato_id,fecha_inicio,monto', 'required'),
			array('contrato_id,monto', 'numerical', 'integerOnly'=>true),
                        array('imagen', 'file', 'types'=>'jpg', 'allowEmpty' => false),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, folio,depto_nombre,propiedad_nombre,cliente_nombre,cliente_rut,contrato_id', 'safe', 'on'=>'search'),
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
        
        protected function gridDataColumn($data,$row)
	{
		return Tools::backFecha($data->fecha_inicio);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
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
		$criteria->compare('contrato_id',$this->contrato_id);
                $criteria->join = 
                        '   join contrato on contrato.id = t.contrato_id'
                . '         join departamento as d on d.id = contrato.departamento_id '
                . '         join propiedad as p on p.id = d.propiedad_id'
                . '         join cliente as c on c.id = contrato.cliente_id '
                . '         join usuario as u on u.id = c.usuario_id ';

                
                $nombre = "";
                $apellido = "";
                $nombres = explode(" ",$this->cliente_nombre);
                if(count($nombres) == 1){
                    $nombre = $this->cliente_nombre;
                    $apellido = $this->cliente_nombre;
                }
                elseif(count($nombres) == 2){
                    $nombre = $nombres[0];
                    $apellido = $nombres[1];
                }
                
                if(Yii::app()->user->rol == 'cliente'){
                    $cliente = Cliente::model()->findByAttributes(array('usuario_id'=>Yii::app()->user->id));
                    if($cliente!=null){
                        $criteria->compare('contrato.cliente_id',$cliente->id);
                    }
                    else{
                        $criteria->compare('contrato.cliente_id',-1);
                    }
                }
                
                $criteria->compare('d.numero',$this->depto_nombre,true);
                $criteria->compare('p.nombre',$this->propiedad_nombre,true);
                $criteria->compare('contrato.folio',$this->folio,true);
                $criteria->compare('c.rut',$this->cliente_rut,true);
                $criteria->compare('u.nombre', $nombre, true,'OR');
                $criteria->compare('u.apellido', $apellido, true,'OR');
		
                return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort' => array(
                            'attributes' => array(
                                'depto_nombre' => array(
                                    'asc' => 'd.numero',
                                    'desc' => 'd.numero DESC',
                                ),
                                'folio' => array(
                                    'asc' => 'contrato.folio',
                                    'desc' => 'contrato.folio DESC',
                                ),
                                'cliente_rut' => array(
                                    'asc' => 'c.rut',
                                    'desc' => 'c.rut DESC',
                                ),
                                'cliente_nombre' => array(
                                    'asc' => 'u.apellido,u.nombre',
                                    'desc' => 'u.apellido DESC,u.nombre DESC',
                                ),
                                'propiedad_nombre' => array(
                                    'asc' => 'p.nombre',
                                    'desc' => 'p.nombre DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
}