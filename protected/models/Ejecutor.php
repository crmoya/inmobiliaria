<?php

/**
 * This is the model class for table "ejecutor".
 *
 * The followings are the available columns in table 'ejecutor':
 * @property integer $id
 * @property string $rut
 * @property string $nombre
 * @property string $direccion
 * @property string $telefono
 * @property string $email
 * @property integer $especialidad_id
 */
class Ejecutor extends CActiveRecord
{
    
    public $especialidad_nm;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Ejecutor the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

        public function listar(){
            $ejecutores = $this->findAll();
            $dev = array();
            foreach($ejecutores as $ejecutor){
                $dev[] = array('id'=>$ejecutor->id,'nombre'=>$ejecutor->nombre." (".$ejecutor->especialidad->nombre.")");
            }
            return $dev;
        }
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ejecutor';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('rut, nombre, direccion, telefono, email, especialidad_id', 'required'),
			array('rut', 'length', 'max'=>11),
			array('rut', 'validateRut'),
                        array('especialidad_id','numerical','integerOnly'=>true),
			array('rut', 'unique'),
			array('nombre, email', 'length', 'max'=>100),
			array('email', 'email'), 
			array('direccion', 'length', 'max'=>200),
			array('telefono', 'length', 'max'=>20),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, rut, nombre,especialidad_nm, direccion, telefono, email, especialidad_id', 'safe', 'on'=>'search'),
		);
	}
	public function validateRut($attribute, $params) {
            $data = explode('-', $this->rut);
            $evaluate = strrev($data[0]);
            $multiply = 2;
            $store = 0;
            for ($i = 0; $i < strlen($evaluate); $i++) {
                $store += $evaluate[$i] * $multiply;
                $multiply++;
                if ($multiply > 7)
                    $multiply = 2;
            }
            isset($data[1]) ? $verifyCode = strtolower($data[1]) : $verifyCode = '';
            $result = 11 - ($store % 11);
            if ($result == 10)
                $result = 'k';
            if ($result == 11)
                $result = 0;
            if ($verifyCode != $result)
                $this->addError('rut', 'Rut inválido.');
        }
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'especialidad' => array(self::BELONGS_TO, 'Especialidad', 'especialidad_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'rut' => 'Rut',
			'nombre' => 'Nombre',
			'direccion' => 'Direccion',
			'telefono' => 'Telefono',
			'email' => 'Email',
			'especialidad_id' => 'Especialidad',
                    'especialidad_nm'=>'Especialidad',
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
                $criteria->with = array('especialidad');
		$criteria->compare('id',$this->id);
		$criteria->compare('rut',$this->rut,true);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('direccion',$this->direccion,true);
		$criteria->compare('telefono',$this->telefono,true);
		$criteria->compare('email',$this->email,true);
                $criteria->compare('especialidad.nombre', $this->especialidad_nm, true );

		return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => array(
                        'attributes' => array(
                            'especialidad_nm' => array(
                                'asc' => 'especialidad.nombre',
                                'desc' => 'especialidad.nombre DESC',
                            ),
                            '*',
                        ),
                    ))
                );
	}
}