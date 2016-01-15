<?php

/**
 * This is the model class for table "contrato".
 *
 * The followings are the available columns in table 'contrato':
 * @property integer $id
 * @property integer $folio
 * @property string $fecha_inicio
 * @property integer $monto_renta
 * @property integer $monto_gastocomun
 * @property integer $monto_mueble
 * @property integer $monto_castigado
 * @property integer $monto_gastovariable
 * @property integer $reajusta_meses
 * @property integer $dia_pago
 * @property integer $plazo
 * @property integer $departamento_id
 * @property integer $cliente_id
 * @property integer $tipo_contrato_id
 * @property integer $monto_primer_mes
 * @property string $dias_primer_mes
 * @property integer $monto_cheque
 *
 * The followings are the available model relations:
 * @property TipoContrato $tipoContrato
 * @property Cliente $cliente
 * @property Departamento $departamento
 * @property ContratoMueble[] $contratoMuebles
 * @property CuentaCorriente $cuentaCorriente
 * @property DebePagar[] $debePagars
 * @property DemandaJudicial[] $demandaJudicials
 * @property PagoMes[] $pagoMes
 */
class Contrato extends CActiveRecord {

    public $depto_nombre;
    public $tipo_nombre;
    public $cliente_nombre;
    public $cliente_rut;
    public $propiedad_id;
    public $imagen;
    public $propiedad_nombre;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Contrato the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'contrato';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('folio','unique'),
            array('imagen', 'file', 'types'=>'jpg', 'allowEmpty' => true),
            array('folio, reajusta_meses, dia_pago,propiedad_id,fecha_inicio, monto_renta, monto_gastocomun, plazo, departamento_id, cliente_id, tipo_contrato_id', 'required'),
            array('folio, monto_primer_mes,monto_cheque, monto_renta, monto_castigado,monto_gastocomun, plazo, monto_mueble,monto_gastovariable,reajusta_meses,dia_pago,departamento_id, cliente_id, tipo_contrato_id', 'numerical', 'integerOnly' => true),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id,cliente_nombre,monto_primer_mes,monto_cheque,dias_primer_mes,monto_mueble,monto_castigado,monto_gastovariable,reajusta_meses,dia_pago,cliente_rut, propiedad_nombre,depto_nombre,tipo_nombre,folio, fecha_inicio, monto_renta, monto_gastocomun, plazo, departamento_id, cliente_id, tipo_contrato_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'tipoContrato' => array(self::BELONGS_TO, 'TipoContrato', 'tipo_contrato_id'),
            'cliente' => array(self::BELONGS_TO, 'Cliente', 'cliente_id'),
            'departamento' => array(self::BELONGS_TO, 'Departamento', 'departamento_id'),
            'cuentaCorriente' => array(self::HAS_ONE, 'CuentaCorriente', 'contrato_id'),
            'pagoMes' => array(self::HAS_MANY, 'PagoMes', 'contrato_id'),
            'debePagars' => array(self::HAS_MANY, 'DebePagar', 'contrato_id'),
            
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'folio' => 'Folio',
            'fecha_inicio' => 'Fecha Inicio',
            'monto_renta' => 'Monto Renta',
            'monto_gastovariable' => 'Monto Gasto Variable',
            'monto_mueble' => 'Monto Muebles',
            'monto_castigado' => 'Monto de Castigo',
            'dia_pago' => 'Día de Pago',
            'reajusta_meses' => 'Reajusta a Meses',
            'monto_gastocomun' => 'Monto Gasto Común',
            'plazo' => 'Plazo',
            'departamento_id' => 'Departamento',
            'cliente_id' => 'Cliente',
            'tipo_contrato_id' => 'Tipo Contrato',
            'depto_nombre' => 'Departamento',
            'tipo_nombre' => 'Tipo Contrato',
            'cliente_nombre' => 'Cliente',
            'propiedad_id'=>'Propiedad',
            'propiedad_nombre'=>'Propiedad',
            'cliente_rut'=>'Rut Cliente',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $nombre = "";
        $apellido = "";
        $nombres = explode(" ",$this->cliente_nombre);
        if(count($nombres) == 1){
            $nombre = $this->cliente_nombre;
            $apellido = $this->cliente_nombre;
        }
        elseif(count($nombres) == 2){
            $nombre = $nombres[0];
            $apellido = $nombres[1];
        }
        
        $criteria = new CDbCriteria;
        $criteria->with = array('departamento', 'tipoContrato', 'cliente');
        $criteria->join .= 'join departamento as d on d.id = t.departamento_id '
                . '         join propiedad as p on p.id = d.propiedad_id'
                . '         join tipo_contrato as tipo on tipo.id = t.tipo_contrato_id '
                . '         join cliente as c on c.id = t.cliente_id '
                . '         join usuario as u on u.id = c.usuario_id ';
        $criteria->compare('id', $this->id);
        $criteria->compare('folio', $this->folio);
        $criteria->compare('fecha_inicio', Tools::fixFecha($this->fecha_inicio), true);
        $criteria->compare('monto_renta', $this->monto_renta);
        $criteria->compare('monto_mueble', $this->monto_mueble);
        $criteria->compare('monto_castigado', $this->monto_castigado);
        $criteria->compare('monto_gastovariable', $this->monto_renta);
        $criteria->compare('monto_gastocomun', $this->monto_gastovariable);
        $criteria->compare('monto_primer_mes', $this->monto_primer_mes);
        $criteria->compare('dias_primer_mes', $this->dias_primer_mes);
        $criteria->compare('monto_cheque', $this->monto_cheque);
        $criteria->compare('reajusta_meses', $this->reajusta_meses);
        $criteria->compare('dia_pago', $this->dia_pago);
        $criteria->compare('plazo', $this->plazo);
        $criteria->compare('departamento_id', $this->departamento_id);
        $criteria->compare('cliente_id', $this->cliente_id);
        $criteria->compare('tipo_contrato_id', $this->tipo_contrato_id);
        $criteria->compare('d.numero', $this->depto_nombre, true);
        $criteria->compare('tipo.nombre', $this->tipo_nombre, true);
        $criteria->compare('c.rut', $this->cliente_rut, true);
        $criteria->compare('u.nombre', $nombre, true,'OR');
        $criteria->compare('u.apellido', $apellido, true,'OR');
        $criteria->compare('p.nombre', $this->propiedad_nombre, true);

        
        if(Yii::app()->user->rol == 'cliente'){
            $cliente = Cliente::model()->findByAttributes(array('usuario_id'=>Yii::app()->user->id));
            if($cliente!=null){
                $criteria->compare('t.cliente_id',$cliente->id);
            }
            else{
                $criteria->compare('t.cliente_id',-1);
            }
        }
        
        if(Yii::app()->user->rol == 'propietario'){
            $contratos = Contrato::model()->relacionadosConPropietario(Yii::app()->user->id);
            foreach($contratos as $contrato_id){
                $criteria->compare('t.id', $contrato_id, false,'OR');   
            }
        }
        
        
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'attributes' => array(
                    'depto_nombre' => array(
                        'asc' => 'd.numero',
                        'desc' => 'd.numero DESC',
                    ),
                    'tipo_nombre' => array(
                        'asc' => 'tipo.nombre',
                        'desc' => 'tipo.nombre DESC',
                    ),
                    'cliente_rut' => array(
                        'asc' => 'c.rut',
                        'desc' => 'c.rut DESC',
                    ),
                    'cliente_nombre' => array(
                        'asc' => 'u.apellido,u.nombre',
                        'desc' => 'u.apellido DESC,u.nombre DESC',
                    ),
                    'propiedad_nombre' => array(
                        'asc' => 'p.nombre',
                        'desc' => 'p.nombre DESC',
                    ),
                    '*',
                ),
            ),
        ));
    }
        /**
         * Entrega un array con los contratos cuya fecha de pago es en nDias más
         * @param int $nDias días que se calculará hacia adelante para ver la fecha de pago
         * @return array arreglo de Contrato 
         */
    public function getCercanosAlPago($nDias){
        $fecha = new DateTime(date('Y-m-d'));
        $fecha->add(new DateInterval("P".$nDias."D"));
        $dia_pago = $fecha->format('d');
        return $this->findAllByAttributes(array('dia_pago'=>$dia_pago));
    }
    
    
    public function crearDeudaMes($fechaHoy){
        //se debe crear un movimiento de cargo por cada pago que se deba efectuar al contrato
        //por si es el primer pago se debe adeudar el monto del primer mes
        $cta_id = $this->cuentaCorriente->id;
        $movimientos = Movimiento::model()->findAllByAttributes(array('cuenta_corriente_id'=>$cta_id));
        if(count($movimientos) == 0){
            $movimiento = new Movimiento();
            $movimiento->fecha = $fechaHoy;
            $movimiento->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
            $movimiento->monto = $this->monto_primer_mes;
            $movimiento->detalle = Tools::DETALLE_PRIMER_CARGO;
            $movimiento->validado = 1;
            $movimiento->cuenta_corriente_id = $cta_id;
            if($movimiento->validate()){
                $movimiento->save();
            }
            else{
                var_dump(CHtml::errorSummary($movimiento));
                die;
            }
        }
    }
    
    public function reajustar($meses){
        
        //si no está insertado en la tabla debe_pagar y además es un reajuste a 0 meses 
        //es porque es el primer pago que se debería hacer.
        //se inserta en debe_pagar con los montos inciales que se reflejan en la tabla contrato        
        $debePagar = DebePagar::model()->findAllByAttributes(array('contrato_id'=>$this->id),array('order'=>'id DESC'));
        if($debePagar == null && $meses == 0){
            $debePagar = new DebePagar();
            $debePagar->agno = (int)date('Y');
            $debePagar->contrato_id = $this->id;
            $debePagar->dia = $this->dia_pago;
            $debePagar->mes = (int)date('m');
            $debePagar->monto_gastocomun = $this->monto_gastocomun;
            $debePagar->monto_gastovariable = $this->monto_gastovariable;
            $debePagar->monto_mueble = $this->monto_mueble;
            $debePagar->monto_renta = $this->monto_renta;
            $debePagar->save(); 
        }
        else{
            //si se reajusta a 6, 8 o 12 meses hay que insertar en la tabla debe_pagar, calculando según el IPC acumulado
            //entre el último reajuste realizado y ahora. 
            $mes_actual = (int)date("m");
            $agno_actual = (int)date('Y');
            $mes_inicio = $mes_actual - $meses;
            $agno_inicio = $agno_actual;
            if($mes_inicio <= 0){
                $agno_inicio -= 1;
                $mes_inicio+= 12;
            }
            $ipcs = array();
            if($agno_inicio != $agno_actual){
                $ipcs = Ipc::model()->findAll(array('order'=>'mes','condition'=>'mes >= :m and agno = :a','params'=>array(':m'=>$mes_inicio,':a'=>$agno_inicio)));
                $ipcs_actual = Ipc::model()->findAll(array('order'=>'mes','condition'=>'mes < :m and agno = :a','params'=>array(':m'=>$mes_actual,':a'=>$agno_actual)));
                foreach($ipcs_actual as $ipc){
                    $ipcs[] = $ipc;
                }
            }
            else{
                $ipcs = Ipc::model()->findAll(array('condition'=>'mes >= :m1 and mes < :m2 and agno = :a','params'=>array(':m1'=>$mes_inicio,':m2'=>$mes_actual,':a'=>$agno_actual)));
            }
           
            $ipc_acumulado = 0;
            foreach($ipcs as $ipc){
                //sumo los ipcs para generar el ipc acumulado
                $ipc_acumulado+= $ipc->porcentaje;
            }
            //para hacer el cálculo según porcentaje
            $ipc_acumulado /= 100;
            
            //ahora hay que reajustar los montos del contrato dependiendo del ipc_acumulado
            //el precio base debe ser el último reajuste hecho al contrato
            //debePagar están ordenados por ID descendientemente, el primero de la lista es el último agregado
            $debeAnterior = $debePagar[0];
            $gastocomun_base = $debeAnterior->monto_gastocomun;
            $gastovariable_base = $debeAnterior->monto_gastovariable;
            $mueble_base = $debeAnterior->monto_mueble;
            $renta_base = $debeAnterior->monto_renta;
            
            $debePagar = new DebePagar();
            $debePagar->agno = (int)date('Y');
            $debePagar->contrato_id = $this->id;
            $debePagar->dia = $this->dia_pago;
            $debePagar->mes = (int)date('m');
            $debePagar->monto_gastocomun = intval($gastocomun_base*(1+$ipc_acumulado));
            $debePagar->monto_gastovariable = intval($gastovariable_base*(1+$ipc_acumulado));
            $debePagar->monto_mueble = intval($mueble_base*(1+$ipc_acumulado));
            $debePagar->monto_renta = intval($renta_base*(1+$ipc_acumulado));
            try{
                //se reajusta el contrato
                $debePagar->save(); 
            } catch (Exception $ex) {
            }
        }
    }
    
    public static function revisarReajustes(){
        $contratos = Contrato::model()->findAll();
        foreach($contratos as $contrato){
            $reajusta_meses = $contrato->reajusta_meses;
            $fecha_inicio = new DateTime($contrato->fecha_inicio);
            $hoy = new DateTime(date("Y-m-d"));
            $interval = $fecha_inicio->diff($hoy);
            $dias_transcurridos = $interval->format('%d');
            $meses_transcurridos = $interval->format('%m');
            $agnos_transcurridos = $interval->format('%y');
            
            $meses_transcurridos = $agnos_transcurridos*12 + $meses_transcurridos;
            switch ($reajusta_meses) {
                case 12:
                    if($meses_transcurridos%12 == 0 && $agnos_transcurridos > 0 && $dias_transcurridos == 0)
                    {
                        $contrato->reajustar(12);
                    }
                    break;
                
                case 8:
                    if($meses_transcurridos%8 == 0 && $dias_transcurridos == 0)
                    {
                        $contrato->reajustar(8);
                    }
                    break;
                    
                case 6:
                    if($meses_transcurridos%6 == 0 && $dias_transcurridos == 0)
                    {
                        $contrato->reajustar(6);
                    }
                    break;
                
                default:
                    break;
            }
        }
    }

    public function estaAsociadoCliente($user_id, $contrato_id) {
        $cliente_id = Cliente::model()->getId($user_id);
        $response = Contrato::model()->exists(array(
            'condition' => 'cliente_id=:clientID AND id=:contratoID',
            'params' => array(':clientID' => $cliente_id, ':contratoID' => $contrato_id),
        ));
        return $response;
    }
    
    public function estaAsociadoACliente($cliente_id) {
        return $this->cliente_id == $cliente_id;
    }
/*
    public function estaAsociadoPropietario($user_id, $contrato_id) {
        $propietario_id = Propietario::model()->getId($user_id);
        $response = Contrato::model()->exists(array(
            'join' => 'JOIN departamento d ON d.id = t.departamento_id JOIN propiedad p ON p.id = d.propiedad_id',
            'condition' => 'propietario_id=:propietarioID AND t.id=:contratoID',
            'params' => array(':propietarioID' => $propietario_id, ':contratoID' => $contrato_id),
        ));
        return $response;
    }
 */   
    public function estaAsociadoPropietario($propietario_id,$contrato_id){
        $contrato = Contrato::model()->findByPk($contrato_id);
        return $contrato->departamento->propiedad->propietario_id == $propietario_id;
    }
    
    public function estaAsociadoAPropietario($propietario_id){
        return $this->departamento->propiedad->propietario_id == $propietario_id;
    }

    protected function gridDataColumn($data, $row) {
        return Tools::backFecha($data->fecha_inicio);
    }

    public function estaRelacionadoConPropietario($propietario_id){
        $contratos = Contrato::model()->findAll();
        $devolver = array();
        foreach($contratos as $contrato){
            $propiedad = $contrato->departamento->propiedad;
            if($propiedad->propietario_id == $propietario_id){
                $devolver[] = $contrato;
            }
        }
        return $devolver;
    }
    
    public function relacionadosConPropietario($propietario_id){
        $contratos = array();
        $propiedades = Propiedad::model()->findAllByAttributes(array('propietario_id'=>$propietario_id));
        foreach($propiedades as $propiedad){
            $departamentos = $propiedad->departamentos;
            foreach($departamentos as $departamento){
                $contrato = $departamento->contrato;
                if(isset($contrato->id)){
                    $contratos[] = $contrato->id;
                }
            }
        }
        return $contratos;
    }
}
