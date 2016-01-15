<?php

/**
 * This is the model class for table "cliente".
 *
 * The followings are the available columns in table 'cliente':
 * @property integer $id
 * @property integer $usuario_id
 * @property string $rut
 * @property string $direccion_alternativa
 * @property string $telefono
 * @property string $ocupacion
 * @property integer $renta
 *
 * The followings are the available model relations:
 * @property Usuario $usuario
 * @property ClienteFiador[] $clienteFiadors
 * @property Contrato[] $contratos
 */
class Cliente extends CActiveRecord
{
    
    public $nombre;
    public $apellido;
    public $email;
    public $clave;
    
    public $fiador_rut;
    public $fiador_nombre;
    public $fiador_apellido;
    public $fiador_email;
    public $fiador_telefono;
    public $fiador_direccion;
    
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Cliente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function esRut($attribute,$params)
        {
            if($this->$attribute != ""){
                $rut = str_replace (".", "", $this->$attribute);
                $arr = explode("-", $rut);
                if(count($arr)!=2){
                    $this->addError($attribute, 'Ingrese un RUT válido, con guión y sin puntos.');
                }
                else{
                    $dv = $arr[1];
                    if(Tools::dv($arr[0])!=$dv){
                         $this->addError($attribute, 'RUT inválido');
                    }
                }
            }
        }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cliente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('usuario_id, rut,nombre,apellido,email', 'required'),
                        array('rut','esRut'),
                        array('fiador_rut','esRut'),
                        array('email','email'),
                        array('fiador_email','email'),
			array('usuario_id, renta', 'numerical', 'integerOnly'=>true),
			array('rut', 'length', 'max'=>11),
			array('telefono,fiador_telefono', 'length', 'max'=>20),
			array('email, ocupacion, fiador_nombre,fiador_apellido', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, usuario_id, rut, direccion_alternativa, telefono, nombre,apellido,email, ocupacion, renta', 'safe', 'on'=>'search'),
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
			'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
			'clienteFiadors' => array(self::HAS_ONE, 'ClienteFiador', 'cliente_id'),
			'contratos' => array(self::HAS_MANY, 'Contrato', 'cliente_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'usuario_id' => 'Usuario',
			'rut' => 'Rut',
			'direccion_alternativa' => 'Direccion Alternativa',
			'telefono' => 'Telefono',
			'email' => 'Email',
			'ocupacion' => 'Ocupacion',
			'renta' => 'Renta',
		);
	}

	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with=array('usuario','contratos');
		$criteria->compare('usuario_id',$this->usuario_id);
		$criteria->compare('t.rut',$this->rut,true);
		$criteria->compare('direccion_alternativa',$this->direccion_alternativa,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('usuario.email',$this->email,true);
		$criteria->compare('ocupacion',$this->ocupacion,true);
		$criteria->compare('renta',$this->renta);
                $criteria->compare('usuario.nombre', $this->nombre, true );
                $criteria->compare('usuario.apellido', $this->apellido, true );
                 
                if(Yii::app()->user->rol == 'propietario'){
                    $clientes = Cliente::model()->relacionadosConPropietario(Yii::app()->user->id);
                    foreach($clientes as $cliente_id){
                        $criteria->compare('t.id', $cliente_id, false,'OR');   
                    }
                }
                
		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort'=>array(
		        'attributes'=>array(
		            'nombre'=>array(
		                'asc'=>'usuario.nombre',
		                'desc'=>'usuario.nombre DESC',
		            ),
                            'apellido'=>array(
		                'asc'=>'usuario.apellido',
		                'desc'=>'usuario.apellido DESC',
		            ),
                            'email'=>array(
		                'asc'=>'usuario.email',
		                'desc'=>'usuario.email DESC',
		            ),
		            '*',
		        ),
		    ),
		));
	}
        
        public function relacionadosConPropietario($propietario_id){
            $clientes = array();
            $propiedades = Propiedad::model()->findAllByAttributes(array('propietario_id'=>$propietario_id));
            foreach($propiedades as $propiedad){
                $departamentos = $propiedad->departamentos;
                foreach($departamentos as $departamento){
                    $contrato = $departamento->contrato;
                    if(isset($contrato->cliente_id)){
                        $cliente_id = $contrato->cliente_id;
                        $clientes[] = $cliente_id;
                    }
                }
            }
            return $clientes;
        }
	/**
	 * Obtiene el Id de cliente a partir del id de usuario
	 */
	public function getId($user_id)
	{
		$client = Cliente::model()->find('usuario_id=:id', array(':id'=>$user_id));
		return ($client == null) ? -1 : $client->id;
	}
	public function getFullNameAndRut()
	{
		$usuario = Usuario::model()->find('id=:id', array(':id'=>$this->usuario_id));
	    return $usuario->nombre.' '.$usuario->apellido.' - ('.$this->rut.')';
	}
	/**
	 * Entrega una lista con todos los departamentos y la propiedad a la que pertenecen
	 * @return CHtml::listData
	 */
	 public function getList()
	 {
	 	$clientes = Cliente::model()->findAll();
	    $listClientes = CHtml::listData($clientes , 'id', 'fullNameAndRut');
	    return $listClientes;
	 }
         
         
}
