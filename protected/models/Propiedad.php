<?php

/**
 * This is the model class for table "propiedad".
 *
 * The followings are the available columns in table 'propiedad':
 * @property integer $id
 * @property integer $propietario_id
 * @property string $nombre
 * @property string $direccion
 * @property double $mt_construidos
 * @property double $mt_terreno
 * @property integer $cant_estacionamientos
 * @property string $inscripcion
 *
 * The followings are the available model relations:
 * @property CuentaCorrientePropietario[] $cuentaCorrientePropietarios
 * @property Departamento[] $departamentos
 * @property Propietario $propietario
 */
class Propiedad extends CActiveRecord
{
    public $propietario_nom;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Propiedad the static model class
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
		return 'propiedad';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propietario_id, nombre, direccion, mt_construidos, mt_terreno, cant_estacionamientos, inscripcion', 'required'),
			array('propietario_id, cant_estacionamientos', 'numerical', 'integerOnly'=>true),
			array('mt_construidos, mt_terreno', 'numerical'),
			array('nombre', 'length', 'max'=>100),
			array('inscripcion', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, propietario_nom,propietario_id, nombre, direccion, mt_construidos, mt_terreno, cant_estacionamientos, inscripcion', 'safe', 'on'=>'search'),
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
			'cuentaCorrientePropietarios' => array(self::HAS_MANY, 'CuentaCorrientePropietario', 'propiedad_id'),
			'departamentos' => array(self::HAS_MANY, 'Departamento', 'propiedad_id'),
			'propietario' => array(self::BELONGS_TO, 'Propietario', 'propietario_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'propietario_id' => 'Propietario',
			'nombre' => 'Nombre',
			'direccion' => 'Direccion',
			'mt_construidos' => 'Metros Construidos',
			'mt_terreno' => 'Metros Terreno',
			'cant_estacionamientos' => 'Cantidad Estacionamientos',
			'inscripcion' => 'Inscripcion',
                        'propietario_nom' => 'Propietario',
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
                $criteria->with = array('propietario');
		$criteria->compare('id',$this->id);
		$criteria->compare('propietario_id',$this->propietario_id);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('mt_construidos',$this->mt_construidos);
		$criteria->compare('mt_terreno',$this->mt_terreno);
		$criteria->compare('cant_estacionamientos',$this->cant_estacionamientos);
		$criteria->compare('inscripcion',$this->inscripcion,true);
                $criteria->compare('propietario.rut', $this->propietario_nom, true);
                
                if(Yii::app()->user->rol == 'propietario'){
                    $propietario = Propietario::model()->findByAttributes(array('usuario_id'=>Yii::app()->user->id));
                    if($propietario != null){
                        $criteria->compare('propietario_id', $propietario->id);
                    }
                    else{
                        $criteria->compare('propietario_id', -1);
                    }
                }
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'sort'=>array(
                            'attributes'=>array(
                                'propietario_nom'=>array(
                                    'asc'=>'propietario.rut',
                                    'desc'=>'propietario.rut DESC',
                                ),
                                '*',
                            ),
                        ),
                        ));
	}
    public function estaAsociadoPropietario($user_id, $propiedad_id) {
        $propietario_id = Propietario::model()->getId($user_id);
        $response = Propiedad::model()->exists(array(
            'condition' => 'propietario_id=:propietarioID AND t.id=:propiedadID',
            'params' => array(':propietarioID' => $propietario_id,':propiedadID' => $propiedad_id),
        ));
        return $response;
    }
    
    public function estaAsociadaAPropietario($user_id){
        $propietario_id = Propietario::model()->getId($user_id);
        return $this->propietario_id == $propietario_id;
    }
    
    public function getDeUsuario($user_id){
        $criteria = new CDbCriteria();
        $criteria->join = "join propietario on propietario.id = t.propietario_id";
        $criteria->condition = "propietario.usuario_id=:usuario_id";
        $criteria->params = array(':usuario_id' => $user_id);
        return $this->findAll($criteria);
    }
}