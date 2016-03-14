<?php

/**
 * This is the model class for table "prestacionesadepartamentos".
 *
 * The followings are the available columns in table 'prestacionesadepartamentos':
 * @property string $id
 * @property string $fecha
 * @property integer $propiedad_id
 * @property integer $departamento_id
 * @property integer $general_prop
 * @property string $documento
 * @property integer $monto
 * @property integer $genera_cargos
 * @property string $descripcion
 * @property string $maestro
 * @property string $tipo
 */
class Prestacionesadepartamentos extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'prestacionesadepartamentos';
	}

        public function getDePropiedadYDepartamento($propiedad,$departamento){
            $criteria = new CDbCriteria();
            $criteria->order = "fecha,propiedad_id,departamento_id";
            if($propiedad != null){
                $criteria->condition = " propiedad = :propiedad";
                $criteria->params = array(':propiedad'=>$propiedad->nombre);
            }
            if($departamento != null){
                $criteria->condition = " propiedad = :propiedad and departamento = :departamento";
                $criteria->params = array(':propiedad'=>$propiedad->nombre,':departamento'=>$departamento->numero);
            }
            $prestaciones = $this->findAll($criteria);
            return $prestaciones;
        }
        
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('fecha, monto, genera_cargos, descripcion, tipo', 'required'),
			array('propiedad_id, departamento_id, general_prop, monto, genera_cargos', 'numerical', 'integerOnly'=>true),
			array('id', 'length', 'max'=>23),
			array('documento', 'length', 'max'=>45),
			array('descripcion', 'length', 'max'=>200),
			array('maestro', 'length', 'max'=>302),
			array('tipo', 'length', 'max'=>100),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, fecha, propiedad_id, departamento_id, general_prop, documento, monto, genera_cargos, descripcion, maestro, tipo', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'fecha' => 'Fecha',
			'propiedad_id' => 'Propiedad',
			'departamento_id' => 'Departamento',
			'general_prop' => 'General Prop',
			'documento' => 'Documento',
			'monto' => 'Monto',
			'genera_cargos' => 'Genera Cargos',
			'descripcion' => 'Descripcion',
			'maestro' => 'Maestro',
			'tipo' => 'Tipo',
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('fecha',$this->fecha,true);
		$criteria->compare('propiedad_id',$this->propiedad_id);
		$criteria->compare('departamento_id',$this->departamento_id);
		$criteria->compare('general_prop',$this->general_prop);
		$criteria->compare('documento',$this->documento,true);
		$criteria->compare('monto',$this->monto);
		$criteria->compare('genera_cargos',$this->genera_cargos);
		$criteria->compare('descripcion',$this->descripcion,true);
		$criteria->compare('maestro',$this->maestro,true);
		$criteria->compare('tipo',$this->tipo,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Prestacionesadepartamentos the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
