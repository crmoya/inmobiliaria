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
 * @property integer $vigente
 * @property string $fecha_finiquito
 * @property integer $reajusta
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

    public $actual;
    public $futuro;
    
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
    
    public function getDeUsuario($usuario_id){
        $contratos = $this->findAll();
        $dev = array();
        foreach($contratos as $contrato){
            $propietario = $contrato->departamento->propiedad->propietario;
            if($propietario->usuario_id == $usuario_id){
                $dev[] = $contrato;
            }
        }
        return $dev;
    }
    
    public static function getReajusta($id){
        $contrato = Contrato::model()->findByPk($id);
        return $contrato->reajusta == 1?'pesoVerde':'pesoRojo';
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
            array('id,vigente,reajusta,fecha_finiquito,cliente_nombre,cliente_rut, propiedad_nombre,depto_nombre,folio, fecha_inicio,cliente_id', 'safe', 'on' => 'search'),
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
            'fecha_finiquito'=>'Fecha Finiquito',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function searchFiniquitados() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.
        
        $criteria = new CDbCriteria;
        $criteria->with = array('departamento', 'tipoContrato', 'cliente');
        $criteria->join .= 'join departamento as d on d.id = t.departamento_id '
                . '         join propiedad as p on p.id = d.propiedad_id'
                . '         join tipo_contrato as tipo on tipo.id = t.tipo_contrato_id '
                . '         join cliente as c on c.id = t.cliente_id '
                . '         join usuario as u on u.id = c.usuario_id ';
        
        $arreglo = explode(" ",$this->cliente_nombre);
        $nombreApellido = array();
        foreach($arreglo as $palabra){
            if(trim($palabra)!= ''){
                $nombreApellido[]=$palabra;
            }
        }
        $criteriaNombreUser1 = new CDbCriteria();
        $palabras = count($nombreApellido);
        if($palabras == 1){
            $busqueda = $nombreApellido[0];
            if(trim($busqueda) != ''){
                $criteriaNombreUser1->compare('u.nombre',$busqueda,true);
                $criteriaNombreUser1->compare('u.apellido',$busqueda,true,'OR');
            }
        }

        if($palabras == 2){
            $nombre = $nombreApellido[0];
            $apellido = $nombreApellido[1];
            $criteriaNombreUser1->compare('u.nombre',$nombre,true);
            $criteriaNombreUser1->compare('u.apellido',$apellido,true);
        }

        $criteria->compare('folio', $this->folio);
        $criteria->mergeWith($criteriaNombreUser1,'AND');
        
        $criteria->compare('fecha_inicio', Tools::fixFecha($this->fecha_inicio), true);
        $criteria->compare('p.nombre', $this->propiedad_nombre, true);
        $criteria->compare('d.numero', $this->depto_nombre, true);
        $criteria->compare('c.rut', $this->cliente_rut, true);
        $criteria->compare('t.vigente', 0);
        $criteria->compare('t.fecha_finiquito', $this->fecha_finiquito,true);
        
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
            $criteriaPropietario = new CDbCriteria();
            $contratos = Contrato::model()->relacionadosConPropietario(Yii::app()->user->id);
            foreach($contratos as $contrato_id){
                $criteriaPropietario->compare('t.id', $contrato_id, false,'OR');   
            }
            $criteria->mergeWith($criteriaPropietario,'AND');
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
    
    public function searchAReajustar() {
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
        
        $arreglo = explode(" ",$this->cliente_nombre);
        $nombreApellido = array();
        foreach($arreglo as $palabra){
            if(trim($palabra)!= ''){
                $nombreApellido[]=$palabra;
            }
        }
        $criteriaNombreUser1 = new CDbCriteria();
        $palabras = count($nombreApellido);
        if($palabras == 1){
            $busqueda = $nombreApellido[0];
            if(trim($busqueda) != ''){
                $criteriaNombreUser1->compare('u.nombre',$busqueda,true);
                $criteriaNombreUser1->compare('u.apellido',$busqueda,true,'OR');
            }
        }

        if($palabras == 2){
            $nombre = $nombreApellido[0];
            $apellido = $nombreApellido[1];
            $criteriaNombreUser1->compare('u.nombre',$nombre,true);
            $criteriaNombreUser1->compare('u.apellido',$apellido,true);
        }

        $criteria->compare('folio', $this->folio);
        $criteria->mergeWith($criteriaNombreUser1,'AND');
        
        $criteria->compare('fecha_inicio', Tools::fixFecha($this->fecha_inicio), true);
        $criteria->compare('p.nombre', $this->propiedad_nombre, true);
        $criteria->compare('d.numero', $this->depto_nombre, true);
        $criteria->compare('c.rut', $this->cliente_rut, true);
        $criteria->compare('t.vigente', 1);
        $criteria->compare('t.reajusta', 1);
        
        
        if(Yii::app()->user->rol == 'cliente'){
            $cliente = Cliente::model()->findByAttributes(array('usuario_id'=>Yii::app()->user->id));
            if($cliente!=null){
                $criteria->compare('t.cliente_id',$cliente->id);
            }
            else{
                $criteria->compare('t.cliente_id',-1);
            }
        }
        
        $criteriaReajustan = new CDbCriteria();
        $reajustan = $this->reajustanProximoMes();
        foreach($reajustan as $reajusta){
            $criteriaReajustan->compare('t.id', $reajusta,false,'OR');
        }
        $criteria->mergeWith($criteriaReajustan,'AND');
        
        
        if(Yii::app()->user->rol == 'propietario'){
            $criteriaPropietario = new CDbCriteria();
            $contratos = Contrato::model()->relacionadosConPropietario(Yii::app()->user->id);
            foreach($contratos as $contrato_id){
                $criteriaPropietario->compare('t.id', $contrato_id, false,'OR');   
            }
            $criteria->mergeWith($criteriaPropietario,'AND');
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
    
    public function searchAvisos() {
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
        
        $arreglo = explode(" ",$this->cliente_nombre);
        $nombreApellido = array();
        foreach($arreglo as $palabra){
            if(trim($palabra)!= ''){
                $nombreApellido[]=$palabra;
            }
        }
        $criteriaNombreUser1 = new CDbCriteria();
        $palabras = count($nombreApellido);
        if($palabras == 1){
            $busqueda = $nombreApellido[0];
            if(trim($busqueda) != ''){
                $criteriaNombreUser1->compare('u.nombre',$busqueda,true);
                $criteriaNombreUser1->compare('u.apellido',$busqueda,true,'OR');
            }
        }

        if($palabras == 2){
            $nombre = $nombreApellido[0];
            $apellido = $nombreApellido[1];
            $criteriaNombreUser1->compare('u.nombre',$nombre,true);
            $criteriaNombreUser1->compare('u.apellido',$apellido,true);
        }

        $criteria->compare('folio', $this->folio);
        $criteria->mergeWith($criteriaNombreUser1,'AND');
        
        $criteria->compare('fecha_inicio', Tools::fixFecha($this->fecha_inicio), true);
        $criteria->compare('p.nombre', $this->propiedad_nombre, true);
        $criteria->compare('d.numero', $this->depto_nombre, true);
        $criteria->compare('c.rut', $this->cliente_rut, true);
        $criteria->compare('t.vigente', 1);
        
        
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
            $criteriaPropietario = new CDbCriteria();
            $contratos = Contrato::model()->relacionadosConPropietario(Yii::app()->user->id);
            foreach($contratos as $contrato_id){
                $criteriaPropietario->compare('t.id', $contrato_id, false,'OR');   
            }
            $criteria->mergeWith($criteriaPropietario,'AND');
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
    
    
    public function reajustanProximoMes(){
        $reajustan = array();
        //se listan solo los contratos que tienen marcado que deben reajustar y están vigentes
        $contratos = Contrato::model()->findAllByAttributes(array('reajusta'=>1,'vigente'=>1));
        
        foreach($contratos as $contrato){
            $reajusta_meses = $contrato->reajusta_meses;
            $fecha_inicioArr = explode('-',$contrato->fecha_inicio);
            $mesInicio = $fecha_inicioArr[1];
            $agnoInicio = $fecha_inicioArr[0];
            $esteMes = date('m');
            $esteAgno = date('Y');
            
            $agnos_transcurridos = $esteAgno - $agnoInicio;
            $meses_transcurridos = $esteMes - $mesInicio;
            if($meses_transcurridos<0){
                $meses_transcurridos+=12;
            }
            $meses_transcurridos = $agnos_transcurridos*12 + $meses_transcurridos;
            
            switch ($reajusta_meses) {
                case 12:
                    if(($meses_transcurridos+1)%12 == 0 && $agnos_transcurridos > 0)
                    {
                        $reajustan[] = $contrato->id;
                    }
                    break;
                
                case 8:
                    if(($meses_transcurridos+1)%8 == 0)
                    {
                        $reajustan[] = $contrato->id;
                    }
                    break;
                    
                case 6:
                    if(($meses_transcurridos+1)%6 == 0)
                    {
                        $reajustan[] = $contrato->id;
                    }
                    break;
                
                default:
                    break;
            }
            
        }
        return $reajustan;
    }
    
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
        
        $arreglo = explode(" ",$this->cliente_nombre);
        $nombreApellido = array();
        foreach($arreglo as $palabra){
            if(trim($palabra)!= ''){
                $nombreApellido[]=$palabra;
            }
        }
        $criteriaNombreUser1 = new CDbCriteria();
        $palabras = count($nombreApellido);
        if($palabras == 1){
            $busqueda = $nombreApellido[0];
            if(trim($busqueda) != ''){
                $criteriaNombreUser1->compare('u.nombre',$busqueda,true);
                $criteriaNombreUser1->compare('u.apellido',$busqueda,true,'OR');
            }
        }

        if($palabras == 2){
            $nombre = $nombreApellido[0];
            $apellido = $nombreApellido[1];
            $criteriaNombreUser1->compare('u.nombre',$nombre,true);
            $criteriaNombreUser1->compare('u.apellido',$apellido,true);
        }

        $criteria->compare('folio', $this->folio);
        $criteria->mergeWith($criteriaNombreUser1,'AND');
        
        $criteria->compare('fecha_inicio', Tools::fixFecha($this->fecha_inicio), true);
        $criteria->compare('p.nombre', $this->propiedad_nombre, true);
        $criteria->compare('d.numero', $this->depto_nombre, true);
        $criteria->compare('c.rut', $this->cliente_rut, true);
        $criteria->compare('t.vigente', 1);
        
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
            $criteriaPropietario = new CDbCriteria();
            $contratos = Contrato::model()->relacionadosConPropietario(Yii::app()->user->id);
            foreach($contratos as $contrato_id){
                $criteriaPropietario->compare('t.id', $contrato_id, false,'OR');   
            }
            $criteria->mergeWith($criteriaPropietario,'AND');
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
        
        //para saber cuánto tiene que pagar, tengo que consultar su debe pagar actual
        $debePagars = DebePagar::model()->findAllByAttributes(array('contrato_id'=>$this->id),array('order'=>'id DESC'));
        $debePagar = null;
        $cta_id = $this->cuentaCorriente->id;
        if(count($debePagars)>0){
            $debePagar = $debePagars[0];
            //si ya se ha pagado otros meses, o sea no es un contrato nuevo
            //se debe crear un movimiento de cargo por cada pago que se deba efectuar al contrato
            //este arreglo sirve por si se cae algún grabar borrar todos los que habían sido guardados
            $idGuardados = array();
            //deuda de renta
            if($this->monto_renta > 0){
                $movimiento = new Movimiento();
                $movimiento->fecha = $fechaHoy;
                $movimiento->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
                $movimiento->monto = $debePagar->monto_renta;
                $movimiento->detalle = "Monto de Renta";
                $movimiento->validado = 1;
                $movimiento->cuenta_corriente_id = $cta_id;
                if($movimiento->save()){
                    $movimiento->actualizaSaldosPosteriores(-$movimiento->monto);
                    $idGuardados[] = $movimiento->id;
                }
                else{
                    foreach($idGuardados as $idGuardado){
                        $movGuardado = Movimiento::model()->findByPk($idGuardado);
                        $movGuardado->delete();
                    }
                    var_dump(CHtml::errorSummary($movimiento));
                    return;
                }
            }

            //deuda de gasto común
            if($this->monto_gastocomun > 0){
                $movimiento = new Movimiento();
                $movimiento->fecha = $fechaHoy;
                $movimiento->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
                $movimiento->monto = $debePagar->monto_gastocomun;
                $movimiento->detalle = "Monto de Gasto Común";
                $movimiento->validado = 1;
                $movimiento->cuenta_corriente_id = $cta_id;
                if($movimiento->save()){
                    $movimiento->actualizaSaldosPosteriores(-$movimiento->monto);
                    $idGuardados[] = $movimiento->id;
                }
                else{
                    foreach($idGuardados as $idGuardado){
                        $movGuardado = Movimiento::model()->findByPk($idGuardado);
                        $movGuardado->delete();
                    }
                    var_dump(CHtml::errorSummary($movimiento));
                    return;
                }
            }

            //deuda de mueble
            if($this->monto_mueble > 0){
                $movimiento = new Movimiento();
                $movimiento->fecha = $fechaHoy;
                $movimiento->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
                $movimiento->monto = $debePagar->monto_mueble;
                $movimiento->detalle = "Monto por Muebles";
                $movimiento->validado = 1;
                $movimiento->cuenta_corriente_id = $cta_id;
                if($movimiento->save()){
                    $movimiento->actualizaSaldosPosteriores(-$movimiento->monto);
                    $idGuardados[] = $movimiento->id;
                }
                else{
                    foreach($idGuardados as $idGuardado){
                        $movGuardado = Movimiento::model()->findByPk($idGuardado);
                        $movGuardado->delete();
                    }
                    var_dump(CHtml::errorSummary($movimiento));
                    return;
                }
            }

            //deuda de gasto variable
            if($this->monto_gastovariable > 0){
                $movimiento = new Movimiento();
                $movimiento->fecha = $fechaHoy;
                $movimiento->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
                $movimiento->monto = $debePagar->monto_gastovariable;
                $movimiento->detalle = "Monto de Gasto Variable";
                $movimiento->validado = 1;
                $movimiento->cuenta_corriente_id = $cta_id;
                if($movimiento->save()){
                    $movimiento->actualizaSaldosPosteriores(-$movimiento->monto);
                    $idGuardados[] = $movimiento->id;
                }
                else{
                    foreach($idGuardados as $idGuardado){
                        $movGuardado = Movimiento::model()->findByPk($idGuardado);
                        $movGuardado->delete();
                    }
                    var_dump(CHtml::errorSummary($movimiento));
                    return;
                }
            }
        }
        //si no hay un debe pagar, quiere decir que recién se creó el contrato, tengo que crear su primer
        //debe pagar y se creará sólo un movimiento que tendrá un cargo por el monto de primer mes
        else{
            $debeNuevo = new DebePagar();
            $debeNuevo->agno = date("Y");
            $debeNuevo->mes = date("m");
            $debeNuevo->dia = $this->dia_pago;
            $debeNuevo->contrato_id = $this->id;
            //ahora hay que reajustar los montos del contrato dependiendo del ipc_acumulado
            //el precio base debe ser el valor anterior en debe pagar
            $debeNuevo->monto_gastocomun = $this->monto_gastocomun;
            $debeNuevo->monto_gastovariable = $this->monto_gastovariable;
            $debeNuevo->monto_mueble = $this->monto_mueble;
            $debeNuevo->monto_renta = $this->monto_renta;
            $debeNuevo->save();
            
            $movimiento = new Movimiento();
            $movimiento->fecha = $fechaHoy;
            $movimiento->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
            $movimiento->monto = $this->monto_primer_mes;
            $movimiento->detalle = Tools::DETALLE_PRIMER_CARGO;
            $movimiento->validado = 1;
            $movimiento->cuenta_corriente_id = $cta_id;
            $movimiento->saldo_cuenta = $movimiento->cuentaCorriente->saldo_inicial - $movimiento->monto;
            $movimiento->save();
        }
    }
    
    public function reajustar(){
        
        //si se reajusta a 6, 8 o 12 meses hay que cambiar el valor en el contrato
        //calculando según el IPC acumulado
        //entre el último reajuste realizado y ahora. 
        $mes_actual = (int)date("m");
        $agno_actual = (int)date('Y');
        $mes_inicio = $mes_actual - $this->reajusta_meses;
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

        //saco el último debe pagar para ver cuánto era lo que tenía que pagar antes
        $debePagars = DebePagar::model()->findAllByAttributes(array('contrato_id'=>$this->id),array('order'=>'id DESC'));
        $debePagar = $debePagars[0];
        
        $debeNuevo = new DebePagar();
        $debeNuevo->agno = $agno_actual;
        $debeNuevo->mes = $mes_actual;
        $debeNuevo->dia = $debePagar->dia;
        $debeNuevo->contrato_id = $this->id;
        //ahora hay que reajustar los montos del contrato dependiendo del ipc_acumulado
        //el precio base debe ser el valor anterior en debe pagar
        $debeNuevo->monto_gastocomun = intval($debePagar->monto_gastocomun*(1+$ipc_acumulado));
        $debeNuevo->monto_gastovariable = intval($debePagar->monto_gastovariable*(1+$ipc_acumulado));
        $debeNuevo->monto_mueble = intval($debePagar->monto_mueble*(1+$ipc_acumulado));
        $debeNuevo->monto_renta = intval($debePagar->monto_renta*(1+$ipc_acumulado));
        try{
            //se reajusta el contrato
            $debeNuevo->save(); 
        } catch (Exception $ex) {
        }
    }

    
    public function getSimulacionReajuste(){
        
        //si se reajusta a 6, 8 o 12 meses hay que cambiar el valor en el contrato
        //calculando según el IPC acumulado
        //entre el último reajuste realizado y ahora. 
        $mes_actual = (int)date("m");
        $agno_actual = (int)date('Y');
        $mes_inicio = $mes_actual - $this->reajusta_meses;
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

        //saco el último debe pagar para ver cuánto era lo que tenía que pagar antes
        $debePagars = DebePagar::model()->findAllByAttributes(array('contrato_id'=>$this->id),array('order'=>'id DESC'));
        $debePagar = $debePagars[0];
        
        $debeNuevo = new DebePagar();
        $debeNuevo->agno = $agno_actual;
        $debeNuevo->mes = $mes_actual;
        $debeNuevo->dia = $debePagar->dia;
        $debeNuevo->contrato_id = $this->id;
        //ahora hay que reajustar los montos del contrato dependiendo del ipc_acumulado
        //el precio base debe ser el valor anterior en debe pagar
        $debeNuevo->monto_gastocomun = intval($debePagar->monto_gastocomun*(1+$ipc_acumulado));
        $debeNuevo->monto_gastovariable = intval($debePagar->monto_gastovariable*(1+$ipc_acumulado));
        $debeNuevo->monto_mueble = intval($debePagar->monto_mueble*(1+$ipc_acumulado));
        $debeNuevo->monto_renta = intval($debePagar->monto_renta*(1+$ipc_acumulado));
        
        return array('actual'=>$debePagar, 'nuevo'=>$debeNuevo);
    }
    
    
    public static function crearDeudas(){
        $contratos = Contrato::model()->findAllByAttributes(array('vigente'=>1));
        $diaActual = date('d');
        $nDias = cal_days_in_month(CAL_GREGORIAN, date('m'),date('Y'));
        foreach($contratos as $contrato){
            if($contrato->dia_pago == int($diaActual)){
                $contrato->crearDeudaMes(date('Y-m-d'));
                continue;
            }
            //si el mes no tiene suficientes días como para alcanzar el día de pago
            //y si además estamos en el día final del mes
            //hay que crear deuda pues o sino no alcanzaría a crearse deuda para ese mes
            if($nDias < $contrato->dia_pago && $nDias == int($diaActual)){
                $contrato->crearDeudaMes(date('Y-m-d'));
            }
        }
    }
        
    
    public static function revisarReajustes(){
        //se listan solo los contratos que tienen marcado que deben reajustar y están vigentes
        $contratos = Contrato::model()->findAllByAttributes(array('reajusta'=>1,'vigente'=>1));
        foreach($contratos as $contrato){
            $reajusta_meses = $contrato->reajusta_meses;
            
            $fecha_inicioArr = explode('-',$contrato->fecha_inicio);
            $mesInicio = $fecha_inicioArr[1];
            $agnoInicio = $fecha_inicioArr[0];
            $esteMes = date('m');
            $esteAgno = date('Y');
            
            $agnos_transcurridos = $esteAgno - $agnoInicio;
            $meses_transcurridos = $esteMes - $mesInicio;
            if($meses_transcurridos<0){
                $meses_transcurridos+=12;
            }
            $meses_transcurridos = $agnos_transcurridos*12 + $meses_transcurridos;
           
            switch ($reajusta_meses) {
                case 12:
                    if($meses_transcurridos%12 == 0 && $agnos_transcurridos > 0)
                    {
                        $contrato->reajustar();
                    }
                    break;
                
                case 8:
                    if($meses_transcurridos%8 == 0)
                    {
                        $contrato->reajustar();
                    }
                    break;
                    
                case 6:
                    if($meses_transcurridos%6 == 0)
                    {
                        $contrato->reajustar();
                    }
                    break;
                
                default:
                    break;
            }
        }
    }
    
    public function estaAsociadoACliente($user_id) {
        $cliente_id = Cliente::model()->getId($user_id);
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
    
    public function estaAsociadoAPropietario($user_id){
        $propietario_id = Propietario::model()->getId($user_id);
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
    
    public function relacionadosConPropietario($usuario_id){
        $propietario_id = Propietario::model()->getId($usuario_id);
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
