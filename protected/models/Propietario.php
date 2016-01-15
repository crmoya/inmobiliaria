<?php

/**
 * This is the model class for table "propietario".
 *
 * The followings are the available columns in table 'propietario':
 * @property integer $id
 * @property string $rut
 * @property string $direccion
 * @property integer $usuario_id
 *
 * The followings are the available model relations:
 * @property Propiedad[] $propiedads
 * @property Usuario $usuario
 */
class Propietario extends CActiveRecord {

    public $nombre;
    public $apellido;
    public $email;
    public $clave;
    
    public function getNombreRut(){
        return $this->usuario->nombre." ".$this->usuario->apellido." (".$this->rut.")";
    }

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Propietario the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    public function esRut($attribute, $params) {

        $rut = str_replace(".", "", $this->$attribute);
        $arr = explode("-", $rut);
        if (count($arr) != 2) {
            $this->addError($attribute, 'Ingrese un RUT válido, con guión y sin puntos.');
        } else {
            $dv = $arr[1];
            if (Tools::dv($arr[0]) != $dv) {
                $this->addError($attribute, 'RUT inválido');
            }
        }
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'propietario';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('rut, direccion,nombre,apellido,email', 'required'),
            array('rut', 'esRut'),
            array('rut', 'unique'),
            array('usuario_id', 'numerical', 'integerOnly' => true),
            array('rut', 'length', 'max' => 11),
            array('direccion', 'length', 'max' => 200),
            array('email,nombre,apellido', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, rut, direccion, email,usuario_id,nombre,apellido', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'propiedads' => array(self::HAS_MANY, 'Propiedad', 'propietario_id'),
            'usuario' => array(self::BELONGS_TO, 'Usuario', 'usuario_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'rut' => 'Rut',
            'email' => 'E-mail',
            'direccion' => 'Direccion',
            'usuario_id' => 'Usuario',
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
        $criteria->with = array('usuario');
        $criteria->compare('id', $this->id);
        $criteria->compare('rut', $this->rut, true);
        $criteria->compare('direccion', $this->direccion, true);
        $criteria->compare('usuario_id', $this->usuario_id);
        $criteria->compare('usuario.nombre', $this->nombre, true);
        $criteria->compare('usuario.apellido', $this->apellido, true);
        $criteria->compare('usuario.email', $this->email, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'nombre' => array(
                        'asc' => 'usuario.nombre',
                        'desc' => 'usuario.nombre DESC',
                    ),
                    'apellido' => array(
                        'asc' => 'usuario.apellido',
                        'desc' => 'usuario.apellido DESC',
                    ),
                    'email' => array(
                        'asc' => 'usuario.email',
                        'desc' => 'usuario.email DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }

    /*     * *
     * Entrega el id del modelo para un usuario_id en particular
     */

    function getFullNameAndRut() {
        $user = Usuario::model()->find('id=:id', array(':id' => $this->usuario_id));
        return $user->nombre . ' ' . $user->apellido . ' - (' . $this->rut . ')';
    }

    function getPropietariosWithRut() {
        $propietarios = Propietario::model()->findAll();
        $listPropietarios = CHtml::listData($propietarios, 'id', 'fullNameAndRut');
        
        return $listPropietarios;
    }

    public function getId($user_id) {
        $propietario = Propietario::model()->find('usuario_id=:id', array(':id' => $user_id));
        return ($propietario == null) ? -1 : $propietario->id;
    }
    public function getAssociatedAccounts($owner_id)
    {
        $accounts = CuentaCorriente::model()->findAll(array(
            'select' => 't.id, t.nombre',
            'join'=>'JOIN contrato c ON t.contrato_id = c.id '
            . '      JOIN departamento d ON c.departamento_id = d.id '
            . '      JOIN propiedad p ON d.propiedad_id = p.id',
            'condition' => 'p.propietario_id = :propietarioID',
            'params' => array(':propietarioID' => $owner_id),
        ));
        $listAccounts = CHtml::listData($accounts, 'id', 'nombre');
        return $listAccounts;
    }
    
    public function getCuentas($owner_id)
    {
        $accounts = CuentaCorriente::model()->findAll(array(
            'join'=>'JOIN contrato c ON t.contrato_id = c.id '
            . '      JOIN departamento d ON c.departamento_id = d.id '
            . '      JOIN propiedad p ON d.propiedad_id = p.id',
            'condition' => 'p.propietario_id = :propietarioID',
            'params' => array(':propietarioID' => $owner_id),
        ));
        return $accounts;
    }
    
}
