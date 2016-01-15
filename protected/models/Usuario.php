<?php

/**
 * This is the model class for table "usuario".
 *
 * The followings are the available columns in table 'usuario':
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property string $clave
 * @property string $rol
 * @property string $email
 *
 * The followings are the available model relations:
 * @property Cliente[] $clientes
 * @property Propietario[] $propietarios
 */
class Usuario extends CActiveRecord
{
    public $nombre_completo;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Usuario the static model class
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
		return 'usuario';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('nombre,apellido,user, clave, rol,email', 'required'),
                        array('email','email'),
                        array('user','unique'),
			array('nombre,email,user,apellido, clave, rol', 'length', 'max'=>100),
                        // The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('nombre_completo,id, nombre,email, user,apellido,clave, rol', 'safe', 'on'=>'search'),
		);
	}
        
        public function esRut($attribute,$params)
        {
            
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

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'clientes' => array(self::HAS_MANY, 'Cliente', 'usuario_id'),
			'propietarios' => array(self::HAS_MANY, 'Propietario', 'usuario_id'),
		);
	}
        
        public function getFullName() {
            return $this->nombre . ' ' . $this->apellido;
        }

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'nombre' => 'Nombre',
                        'apellido' => 'Apellido',
                        'email' => 'E-mail',
			'clave' => 'Clave',
			'rol' => 'Rol',
                        'user' => 'Usuario',
                        'nombre_completo' => 'Nombre Completo',
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
                $criteria->compare('email',$this->email,true);
                $criteria->compare('apellido',$this->apellido,true);
                $criteria->compare('user',$this->user,true);
		$criteria->compare('clave',$this->clave,true);
		$criteria->compare('rol',$this->rol,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchUsuarios()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('nombre',$this->nombre,true);
                $criteria->compare('email',$this->email,true);
		$criteria->compare('apellido',$this->apellido,true);
                $criteria->compare('nombre_completo',$this->nombre_completo,true);
                $criteria->compare('user',$this->user,true);
		$criteria->compare('clave',$this->clave,true);
                $criteria->compare('rol',$this->rol,true);
		$criteria->compare('rol',array('superusuario','administrativo'),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}