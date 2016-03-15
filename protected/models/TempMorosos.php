<?php

/**
 * This is the model class for table "temp_morosos".
 *
 * The followings are the available columns in table 'temp_morosos':
 * @property integer $id
 * @property string $propiedad
 * @property string $departamento
 * @property integer $monto
 * @property string $fecha
 * @property integer $dias
 * @property string $nombre
 * @property string $apellido
 * @property integer $cuenta_corriente_id
 * @property integer $contrato_id
 *
 * The followings are the available model relations:
 * @property CuentaCorriente $cuentaCorriente
 */
class TempMorosos extends CActiveRecord
{
    public $nombre_ap;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'temp_morosos';
	}

        public function refrescar(){
            $this->deleteAll();
            $cuentas = CuentaCorriente::model()->getVigentes();

            foreach($cuentas as $cuenta){
                $saldo = $cuenta->saldoAFecha(date("Y-m-d"));
                if($saldo<0){
                    $moroso = new TempMorosos();
                    $moroso->apellido = $cuenta->contrato->cliente->usuario->apellido;
                    $moroso->departamento = $cuenta->contrato->departamento->numero;
                    $moroso->fecha = $cuenta->fechaUltimaMora();
                    $diff = date_diff(date_create(date("Y-m-d")),date_create($moroso->fecha), true);
                    $moroso->dias = $diff->format("%a");
                    $moroso->monto = -$saldo;
                    $moroso->nombre = $cuenta->contrato->cliente->usuario->nombre;
                    $moroso->propiedad = $cuenta->contrato->departamento->propiedad->nombre;
                    $moroso->cuenta_corriente_id = $cuenta->id;
                    $moroso->contrato_id = $cuenta->contrato->id;
                    $moroso->save();
                }
            }
        }
        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('propiedad, departamento, monto, fecha, dias, nombre, apellido, cuenta_corriente_id', 'required'),
			array('monto, dias, cuenta_corriente_id', 'numerical', 'integerOnly'=>true),
			array('propiedad, nombre, apellido', 'length', 'max'=>100),
			array('departamento', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, propiedad, nombre_ap,departamento, monto, fecha, dias, nombre, apellido, cuenta_corriente_id', 'safe', 'on'=>'search'),
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
			'cuentaCorriente' => array(self::BELONGS_TO, 'CuentaCorriente', 'cuenta_corriente_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'propiedad' => 'Propiedad',
			'departamento' => 'Departamento',
			'monto' => 'Monto',
			'fecha' => 'Fecha',
			'dias' => 'Dias',
			'nombre' => 'Nombre',
                        'nombre_ap'=>'Nombre',
			'apellido' => 'Apellido',
			'cuenta_corriente_id' => 'Cuenta Corriente',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

                $arreglo = explode(" ",$this->nombre_ap);
                $nombreApellido = array();
                foreach($arreglo as $palabra){
                    if(trim($palabra)!= ''){
                        $nombreApellido[]=$palabra;
                    }
                }
                $criteriaNombre = new CDbCriteria();
                $palabras = count($nombreApellido);
                if($palabras == 1){
                    $busqueda = $nombreApellido[0];
                    if(trim($busqueda) != ''){
                        $criteriaNombre->compare('nombre',$busqueda,true);
                        $criteriaNombre->compare('apellido',$busqueda,true,'OR');
                    }
                }
                
                if($palabras == 2){
                    $nombre = $nombreApellido[0];
                    $apellido = $nombreApellido[1];
                    $criteriaNombre->compare('nombre',$nombre,true);
                    $criteriaNombre->compare('apellido',$apellido,true);
                }
                
		$criteria->compare('id',$this->id);
                $criteria->mergeWith($criteriaNombre,'AND');
		$criteria->compare('propiedad',$this->propiedad,true);
		$criteria->compare('departamento',$this->departamento,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('fecha',Tools::fixFecha($this->fecha));
		$criteria->compare('dias',$this->dias);
                
                
                if(Yii::app()->user->rol == 'propietario'){
                    $criteriaPropietario = new CDbCriteria();
                    $contratos = Contrato::model()->relacionadosConPropietario(Yii::app()->user->id);
                    foreach($contratos as $contrato_id){
                        $criteriaPropietario->compare('t.contrato_id', $contrato_id, false,'OR');   
                    }
                    $criteria->mergeWith($criteriaPropietario,'AND');
                }


		$data = new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                        'sort' => array(
                            'attributes' => array(
                                'nombre_ap' => array(
                                    'asc' => 'apellido,nombre',
                                    'desc' => 'apellido DESC,nombre',),
                                '*',
                            ),
                        )
                    )
                );
                Yii::app()->user->setState('morososFiltrados',$this);
                return $data;
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TempMorosos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
