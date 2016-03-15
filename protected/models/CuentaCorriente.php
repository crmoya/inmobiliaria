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
    
    public function getVigentes(){
        $criteria = new CDbCriteria();
        $criteria->join = "join contrato c on t.contrato_id = c.id";
        $criteria->condition = "c.vigente = 1";
        return $this->findAll($criteria);
    }
    
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
        
        public function estaAsociadoPropietario($user_id){
            $propietario_id = Propietario::model()->getId($user_id);
            return $this->contrato->departamento->propiedad->propietario_id == $propietario_id;
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
                'fecha_morosidad'=>'Fecha',
                'monto_morosidad'=>'Monto',
                'dias_morosidad'=>'Días',
                'nombre_cliente'=>'Nombre',
            );
	}
        
        
        
        public function idMovUltimoSaldo0(){
            $movimientos = Movimiento::model()->findAll(array(
                'condition'=>':cuenta = cuenta_corriente_id and saldo_cuenta = 0',
                'params'=>array(':cuenta'=>$this->id),
                'order'=>'fecha DESC,id DESC',
            ));
            if(count($movimientos)>0){
                return $movimientos[0]->id;
            }
            return -1;
        }
        
        public function fechaUltimaMora(){
            $movimientos = Movimiento::model()->findAllByAttributes(
                array('cuenta_corriente_id'=>$this->id),
                array('order'=>'fecha DESC,id DESC')
            );
            $mov = null;
            foreach($movimientos as $movimiento){
                if($movimiento->saldo_cuenta < 0){
                    $mov = $movimiento;
                }
                else{
                    if($mov != null){
                        return $mov->fecha;
                    }
                }
            }
            return $mov != null?$mov->fecha:"";
        }

        public function saldoAFecha($fecha){
            $movimientos = Movimiento::model()->findAll(
                array(
                    'condition'=>'fecha <= :fecha and cuenta_corriente_id = :cta and validado = 1',
                    'params'=>array(':fecha'=>$fecha,':cta'=>$this->id),
                    'order'=>'fecha DESC,id DESC',
                )
            );
            if(count($movimientos)>0){
                return $movimientos[0]->saldo_cuenta;
            }
            else{
                return $this->saldo_inicial;
            }
        }
        
        public function saldoMes($mes,$agno){
            $proxMes = $mes+1;
            $proxAgno = $agno;
            if($proxMes > 12){
                $proxMes = 1;
                $proxAgno = $agno+1;
            }
            $fDesde = $agno."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-01";
            $fHasta = $proxAgno."-".str_pad($proxMes,2,"0",STR_PAD_LEFT)."-01";
            $movimientos = Movimiento::model()->findAll(
                array(
                    'condition'=>'fecha >= :fDesde and fecha < :fHasta and cuenta_corriente_id = :cta',
                    'params'=>array(':fDesde'=>$fDesde,':fHasta'=>$fHasta,':cta'=>$this->id),
                ));
            $abonos = 0;
            $cargos = 0;
            foreach($movimientos as $movimiento){
                if($movimiento->tipo == Tools::MOVIMIENTO_TIPO_ABONO){
                    $abonos += $movimiento->monto;
                }
                else if($movimiento->tipo == Tools::MOVIMIENTO_TIPO_CARGO){
                    $cargos -= $movimiento->monto;
                }
            }
            return array('abonos'=>$abonos,'cargos'=>-$cargos);
        }

        
        public function movimientosDeMes($mes,$agno){
            $proxMes = $mes+1;
            $proxAgno = $agno;
            if($proxMes > 12){
                $proxMes = 1;
                $proxAgno = $agno+1;
            }
            $fDesde = $agno."-".str_pad($mes,2,"0",STR_PAD_LEFT)."-01";
            $fHasta = $proxAgno."-".str_pad($proxMes,2,"0",STR_PAD_LEFT)."-01";
            $movimientos = Movimiento::model()->findAll(
                array(
                    'condition'=>'fecha >= :fDesde and fecha < :fHasta and cuenta_corriente_id = :cta',
                    'params'=>array(':fDesde'=>$fDesde,':fHasta'=>$fHasta,':cta'=>$this->id),
                ));
            return $movimientos;
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
