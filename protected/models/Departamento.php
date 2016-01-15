<?php

/**
 * This is the model class for table "departamento".
 *
 * The followings are the available columns in table 'departamento':
 * @property integer $id
 * @property integer $propiedad_id
 * @property double $mt2
 * @property integer $dormitorios
 * @property integer $estacionamientos
 * @property integer $renta
 * @property string $numero
 *
 * The followings are the available model relations:
 * @property Contrato $contrato
 * @property Propiedad $propiedad
 */
class Departamento extends CActiveRecord
{
    
    public $propiedad_nombre;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Departamento the static model class
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
		return 'departamento';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propiedad_id, mt2, dormitorios, estacionamientos, renta', 'required'),
			array('propiedad_id, dormitorios, estacionamientos, renta', 'numerical', 'integerOnly'=>true),
			array('mt2', 'numerical'),
			array('numero', 'length', 'max'=>10),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, propiedad_id,propiedad_nombre, mt2, dormitorios, estacionamientos, renta, numero', 'safe', 'on'=>'search'),
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
			'contrato' => array(self::HAS_ONE, 'Contrato', 'departamento_id'),
			'propiedad' => array(self::BELONGS_TO, 'Propiedad', 'propiedad_id'),
                        'prestacionADepartamento' => array(self::HAS_MANY, 'PrestacionADepartamento', 'departamento_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'propiedad_id' => 'Propiedad',
                        'propiedad_nombre' => 'Propiedad',
			'mt2' => 'Metros Cuadrados',
			'dormitorios' => 'Dormitorios',
			'estacionamientos' => 'Estacionamientos',
			'renta' => 'Renta',
			'numero' => 'Número',
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
                $criteria->with=array('propiedad','contrato');	
		$criteria->compare('propiedad_id',$this->propiedad_id);
		$criteria->compare('mt2',$this->mt2);
                $criteria->compare('propiedad.nombre', $this->propiedad_nombre, true );
		$criteria->compare('dormitorios',$this->dormitorios);
		$criteria->compare('estacionamientos',$this->estacionamientos);
		$criteria->compare('renta',$this->renta);
		$criteria->compare('numero',$this->numero,true);
                
                if(Yii::app()->user->rol == 'cliente'){
                    $cliente = Cliente::model()->findByAttributes(array('usuario_id'=>Yii::app()->user->id));
                    if($cliente!=null){
                        $criteria->compare('contrato.cliente_id',$cliente->id);
                    }
                    else{
                        $criteria->compare('contrato.cliente_id',-1);
                    }
                }

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
                                'propiedad_nombre'=>array(
                                    'asc'=>'propiedad.nombre',
                                    'desc'=>'propiedad.nombre DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
        public function searchChb()
	{
		$criteria=new CDbCriteria;
                $criteria->with=array('propiedad');	
		$criteria->compare('id',$this->id);
                $criteria->compare('propiedad.nombre', $this->propiedad_nombre, true );
		$criteria->compare('propiedad_id',$this->propiedad_id);
		$criteria->compare('mt2',$this->mt2);
		$criteria->compare('dormitorios',$this->dormitorios);
		$criteria->compare('estacionamientos',$this->estacionamientos);
		$criteria->compare('renta',$this->renta);
		$criteria->compare('numero',$this->numero,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
                        'sort'=>array(
                            'attributes'=>array(
                                'propiedad_nombre'=>array(
                                    'asc'=>'propiedad.nombre',
                                    'desc'=>'propiedad.nombre DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
        
        public function searchPrestacion($id)
	{
		$criteria=new CDbCriteria;
                $criteria->with=array('propiedad','prestacionADepartamento');	
		$criteria->compare('prestacionADepartamento.prestacion_id',$id);
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>false,
                        'sort'=>array(
                            'attributes'=>array(
                                'propiedad_nombre'=>array(
                                    'asc'=>'propiedad.nombre',
                                    'desc'=>'propiedad.nombre DESC',
                                ),
                                '*',
                            ),
                        ),
		));
	}
	public function getPropiedadYNumero()
	{
		$propiedad = Propiedad::model()->find('id=:id', array(':id'=>$this->propiedad_id));
	    return $propiedad->nombre.' - ('.$this->numero.')';
	}
	/**
	 * Entrega una lista con todos los departamentos y la propiedad a la que pertenecen
	 * @return CHtml::listData
	 */
	 public function getList()
	 {
	 	$departamentos = Departamento::model()->findAll(array('order'=>'propiedad_id'));
	    $listDepartamentos = CHtml::listData($departamentos , 'id', 'propiedadYNumero');
	    return $listDepartamentos;
	 }
     public function getListWithoutContract()
	 {
	 	$departamentos = Departamento::model()->findAll(array(
            'join'=>'LEFT JOIN contrato c ON t.id = c.departamento_id',
            'condition'=>'c.id IS NULL',
            'order'=>'propiedad_id'));
	    $listDepartamentos = CHtml::listData($departamentos , 'id', 'propiedadYNumero');
	    return $listDepartamentos;
	 }
         
          public function getListWithoutContractProp($propiedad_id)
	 {
	 	$departamentos = Departamento::model()->findAll(array(
            'join'=>'LEFT JOIN contrato c ON t.id = c.departamento_id',
            'condition'=>"c.id IS NULL and propiedad_id = '$propiedad_id'",
            'order'=>'propiedad_id'));
	    return $departamentos;
	 }
     public function estaAsociadoCliente($user_id, $departamento_id) {
        $cliente_id = Cliente::model()->getId($user_id);
        $response = Departamento::model()->exists(array(
            'join' => 'JOIN contrato c ON t.id = c.departamento_id',
            'condition' => 'cliente_id=:clientID AND t.id=:departamentoID',
            'params' => array(':clientID' => $cliente_id,':departamentoID' => $departamento_id),
        ));
        return $response;
    }
       
    public function estaAsociadoPropietario($user_id, $departamento_id) {
        $propietario_id = Propietario::model()->getId($user_id);
        $response = Departamento::model()->exists(array(
            'join' => 'JOIN propiedad p ON p.id = t.propiedad_id',
            'condition' => 'propietario_id=:propietarioID AND t.id=:departamentoID',
            'params' => array(':propietarioID' => $propietario_id,':departamentoID' => $departamento_id),
        ));
        return $response;
    }
    /**
     * Indica si se han pagado todas las deudas del mes
     */
    public function estaAlDia()
    {
        $fecha_hoy = date('Y-m-d');
        $hoy = strtotime($fecha_hoy);
        $fecha_pago = date("Y-m").$this->contrato->dia_pago;
        $pago = strtotime($fecha_pago);
        if($hoy <= $pago)
            $ultima_fecha = date("Y-m-d", mktime(0, 0, 0, date("m")-1, $this->contrato->dia_pago,   date("Y")));
        else
            $ultima_fecha = date("Y-m").$this->contrato->dia_pago;
        $debe_pagar = DebePagar::model()->getCantidadAPagar($ultima_fecha, $this->contrato->id);
        $ultimo_pago = PagoMes::model()->ultimoPago($this->contrato->id);
        if($debe_pagar == null)
            return true;
        else{
            if($ultimo_pago == null){
                return false;
            }
            else{
                $fecha_ultimo_pago = strtotime($ultimo_pago->fecha);
                $fecha_debe_pagar = strtotime($debe_pagar->agno."-".$debe_pagar->mes."-".$debe_pagar->dia);
                if($fecha_ultimo_pago > $fecha_debe_pagar)
                {
                    return true;
                }
                elseif ($fecha_ultimo_pago >= $fecha_debe_pagar) {
                    if($debe_pagar->monto_renta == $ultimo_pago->monto_renta &&
                       $debe_pagar->monto_gastocomun == $ultimo_pago->gasto_comun &&
                       $debe_pagar->monto_mueble == $ultimo_pago->monto_mueble &&
                       $debe_pagar->monto_gastovariable == $ultimo_pago->gasto_variable){
                        return true;
                    }
                    else{
                        return false;
                    }
                }
                else{
                    return false;
                }                
            }
        }   
    }
}