<?php

/**
 * This is the model class for table "cuenta_corriente_propietario".
 *
 * The followings are the available columns in table 'cuenta_corriente_propietario':
 * @property integer $id
 * @property integer $propietario_id
 * @property integer $cuenta_corriente_id
 *
 * The followings are the available model relations:
 * @property CuentaCorriente $cuentaCorriente
 * @property Propietario $propietario
 */
class CuentaCorrientePropietario extends CActiveRecord 
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CuentaCorrientePropietario the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'cuenta_corriente_propietario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('propietario_id, cuenta_corriente_id', 'required'),
            array('propietario_id, cuenta_corriente_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, propietario_id, cuenta_corriente_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'cuentaCorriente' => array(self::BELONGS_TO, 'CuentaCorriente', 'cuenta_corriente_id'),
            'propietario' => array(self::BELONGS_TO, 'Propietario', 'propietario_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'propietario_id' => 'Propietario',
            'cuenta_corriente_id' => 'Cuenta Corriente',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('propietario_id', $this->propietario_id);
        $criteria->compare('cuenta_corriente_id', $this->cuenta_corriente_id);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /*     * *
     * Determina si el usuario es dueño de esa cuenta o no
     */

    public function isOwner($user_id, $cta_id) {
        $prop_id = Propietario::model()->getId($user_id);
        $response = CuentaCorrientePropietario::model()->exists('cuenta_corriente_id=:cc_id AND propietario_id=:prop_id', array(':cc_id' => $cta_id, ':prop_id' => $prop_id));
        return $response;
    }
    
    public function isCuentaCorrientePropietario($cta_id)
    {
        $response = CuentaCorrientePropietario::model()->exists('cuenta_corriente_id=:cc_id', array(':cc_id' => $cta_id));
        return $response;
    }
}
