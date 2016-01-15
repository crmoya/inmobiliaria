<?php

/**
 * This is the model class for table "cuenta_corriente".
 *
 * The followings are the available columns in table 'cuenta_corriente':
 * @property integer $id
 * @property integer $saldo_inicial
 * @property string $nombre
 * @property integer $contrato_id
 *
 * The followings are the available model relations:
 * @property Contrato $contrato
 * @property Movimiento[] $movimientos
 */
class CuentaCorriente extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cuenta_corriente';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('saldo_inicial, nombre, contrato_id', 'required'),
			array('saldo_inicial, contrato_id', 'numerical', 'integerOnly'=>true),
			array('nombre', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, saldo_inicial, nombre, contrato_id', 'safe', 'on'=>'search'),
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
			'movimientos' => array(self::HAS_MANY, 'Movimiento', 'cuenta_corriente_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'saldo_inicial' => 'Saldo Inicial',
			'nombre' => 'Nombre',
			'contrato_id' => 'Contrato',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('saldo_inicial',$this->saldo_inicial);
		$criteria->compare('nombre',$this->nombre,true);
		$criteria->compare('contrato_id',$this->contrato_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CuentaCorriente the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        public function isOwnerClient($user_id, $cta_id) {
            $client_id = Cliente::model()->getId($user_id);
            $cuenta = CuentaCorriente::model()->findByPk($cta_id);
            return $cuenta->contrato->cliente_id == $client_id;
        }
        
        public function isOwnerProp($user_id, $cta_id) {
            $prop_id = Propietario::model()->getId($user_id);
            $cuenta = CuentaCorriente::model()->findByPk($cta_id);
            return $cuenta->contrato->departamento->propiedad->propietario_id == $prop_id;
        }
}
