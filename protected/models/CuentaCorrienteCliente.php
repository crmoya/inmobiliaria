<?php

/**
 * This is the model class for table "cuenta_corriente_cliente".
 *
 * The followings are the available columns in table 'cuenta_corriente_cliente':
 * @property integer $cuenta_corriente_id
 * @property integer $contrato_id
 * @property integer $id
 *
 * The followings are the available model relations:
 * @property Contrato $contrato
 * @property CuentaCorriente $cuentaCorriente
 */
class CuentaCorrienteCliente extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CuentaCorrienteCliente the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cuenta_corriente_cliente';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('cuenta_corriente_id, contrato_id', 'required'),
            array('cuenta_corriente_id, contrato_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('cuenta_corriente_id, contrato_id, id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'contrato' => array(self::BELONGS_TO, 'Contrato', 'contrato_id'),
            'cuentaCorriente' => array(self::BELONGS_TO, 'CuentaCorriente', 'cuenta_corriente_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'cuenta_corriente_id' => 'Cuenta Corriente',
            'contrato_id' => 'Contrato',
            'id' => 'ID',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('cuenta_corriente_id', $this->cuenta_corriente_id);
        $criteria->compare('contrato_id', $this->contrato_id);
        $criteria->compare('id', $this->id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*     * *
     * Determina si el usuario es dueño de esa cuenta o no
     */

    public function isOwner($user_id, $cta_id) {
        $client_id = Cliente::model()->getId($user_id);
        $response = CuentaCorrienteCliente::model()->exists(array(
            'join' => 'JOIN contrato c ON t.contrato_id = c.id',
            'condition' => 'c.cliente_id=:clientID AND t.cuenta_corriente_id = :ctaID',
            'params' => array(':clientID' => $client_id, ':ctaID' => $cta_id),
        ));
        return $response;
    }

}
