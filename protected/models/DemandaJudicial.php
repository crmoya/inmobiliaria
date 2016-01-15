<?php

/**
 * This is the model class for table "demanda_judicial".
 *
 * The followings are the available columns in table 'demanda_judicial':
 * @property integer $id
 * @property string $rol
 * @property string $causa
 * @property integer $contrato_id
 * @property integer $formato_demanda_id
 *
 * The followings are the available model relations:
 * @property Contrato $contrato
 * @property FormatoDemanda $formatoDemanda
 */
class DemandaJudicial extends CActiveRecord
{
    public $folio;
    public $cliente_rut;
    public $formato;
    public $cliente_nombre;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return DemandaJudicial the static model class
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
		return 'demanda_judicial';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rol, causa, contrato_id,formato_demanda_id', 'required'),
			array('contrato_id,formato_demanda_id', 'numerical', 'integerOnly'=>true),
			array('rol', 'length', 'max'=>45),
			array('causa', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, formato,cliente_rut,cliente_nombre,folio,rol, causa, contrato_id,formato_demanda_id', 'safe', 'on'=>'search'),
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
                        'formatoDemanda' => array(self::BELONGS_TO, 'FormatoDemanda', 'formato_demanda_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rol' => 'Rol',
			'causa' => 'Causa',
			'contrato_id' => 'Contrato',
                        'folio'=>'Folio Contrato',
                        'cliente_rut'=>'Rut Cliente',
                        'cliente_nombre'=>'Cliente',
                        'formato' => 'Formato Demanda',
                        'formato_demanda_id'=>'Formato Demanda',
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
		$criteria->compare('rol',$this->rol,true);
		$criteria->compare('causa',$this->causa,true);
		$criteria->compare('contrato_id',$this->contrato_id);
                $criteria->compare('f.nombre',$this->formato);
                $criteria->compare('formato_demanda_id',$this->formato_demanda_id);
                $criteria->join = 
                        '   join contrato on contrato.id = t.contrato_id'
                . '         join cliente as c on c.id = contrato.cliente_id '
                . '         join usuario as u on u.id = c.usuario_id '
                        . ' join formato_demanda as f on f.id = t.formato_demanda_id';
                $criteria->compare('contrato.folio',$this->folio);
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
                $criteria->compare('c.rut',$this->cliente_rut,true);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    'sort'=>array(
		        'attributes'=>array(
		            'folio'=>array(
		                'asc'=>'contrato.folio',
		                'desc'=>'contrato.folio DESC',
		            ),
                            'cliente_rut'=>array(
		                'asc'=>'c.rut',
		                'desc'=>'c.rut DESC',
		            ),
                            'cliente_nombre'=>array(
		                'asc'=>'u.apellido,u.nombre',
		                'desc'=>'u.apellido DESC,u.nombre DESC',
		            ),
                            'formato'=>array(
		                'asc'=>'f.nombre',
		                'desc'=>'f.nombre DESC',
		            ),
		            '*',
		        ),
		    ),
		));
	}
}