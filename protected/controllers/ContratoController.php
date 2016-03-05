<?php

class ContratoController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    public function behaviors() {
        return array(
            'eexcelview' => array(
                'class' => 'ext.eexcelview.EExcelBehavior',
            ),
            'doccy' => array(
                'class' => 'ext.doccy.Doccy',
                'options' => array(
                    'templatePath' => Yii::app()->basePath.'/documentos/tipoContrato',  // Path where docx templates are stored. Default value is controller`s view folder 
                    'outputPath' => Yii::app()->basePath.'/documentos/contratos',  // Path where output files should be stored. Default value is application runtime folder 
                    //'docxgenFolder' => 'docxgen-master',  // Name of the folder which holds docxgen library (must be in the extension folder). Default value is 'docxgen-master' 
                 ),
            ),
        );
    }
 
    /**
     * @return array action filters
     */
    public function filters() {
        return array(
            'accessControl', // perform access control for CRUD operations
            'postOnly + delete', // we only allow deletion via POST request
        );
    }

    /**
     * Specifies the access control rules.
     * This method is used by the 'accessControl' filter.
     * @return array access control rules
     */
    public function accessRules() {       // @todo: Revisar los permisos
        return array(
            array('allow',
                'actions' => array('reajusta', 'delete','verMontos','crearCarta','finiquitar', 'view','viewCliente','update','download','getNombreCliente','descargarCarta','create', 'exportarXLS','update','download','adminReajustes','adminAReajustar','adminAvisos','admin','adminAviso','adminAbonos','adminCargos','adminFiniquitados'),
                'roles' => array('superusuario','propietario'),
            ),
            array('allow',
                'actions' => array('admin','download','view'),
                'roles' => array('cliente'),
            ),
            array('allow', 
                'actions' => array('cartasAutomaticas','reajustes'),
                'users' => array('*'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionReajusta($id){
        $contrato = Contrato::model()->findByPk($id);
        $contrato->reajusta = $contrato->reajusta==1?0:1;
        $contrato->propiedad_id = $contrato->departamento->propiedad_id;
        $contrato->save();
        $this->redirect(CController::createUrl('//contrato/admin'));
    }
    
    public function actionFiniquitar($id){
        $modelo = Contrato::model()->findByPk($id);
        //fix bug que había por propiedad dependiente
        $modelo->propiedad_id = $modelo->departamento->propiedad_id;
        //end fix
        $modelo->vigente = 0;
        $modelo->fecha_finiquito = date('Y-m-d');
        if($modelo->save()){
            Yii::app()->user->setFlash('success','Contrato finiquitado correctamente.');
            $this->redirect(CController::createUrl('//contrato/admin'));
        }
        else{
            Yii::app()->user->setFlash('error','ERROR: No se pudo finiquitar el contrato: '.CHtml::errorSummary($modelo));
            $this->redirect(CController::createUrl('//contrato/admin'));
        }
    }
    public function actionCartasAutomaticas(){
        if($_GET['code'] == 'c87680eabb5d1e6283dea432b5a567f3'){
            $contratos = Contrato::model()->getCercanosAlPago(Tools::DIAS_FECHA_PAGO_CERCANA);
            foreach($contratos as $contrato){
                $formato = new FormatoCartaForm();
                $formato->contrato_id = $contrato->id;
                $formato->formato = Tools::FORMATO_CARTA_FECHA_PAGO_CERCANA;
                $this->crearCarta($formato);
                CartaAviso::enviarCarta($formato);
            }
        }
    }
    
    public function actionViewCliente($id)
    {
        $this->render('view',array(
                'model'=>$this->loadModel($id),
        ));
    }
    
    public function actionVerMontos($id)
    {
        $this->render('viewMontos',array(
                'model'=>$this->loadModel($id),
        ));
    }
    
    public function actionCrearDeudas(){
        if($_GET['code'] == 'c87680eabb5d1e6283dea432b5a567f3'){
            //si es 1ro del mes se deben revisar reajustes antes de crear deudas
            if((int)date('d') == 1){
                Contrato::revisarReajustes();
            }
            Contrato::crearDeudas();
        }
    }
    
    public function actionReajustes(){
        if($_GET['code'] == 'c87680eabb5d1e6283dea432b5a567f3'){
            Contrato::revisarReajustes();
        }
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
        $model = $this->loadModel($id);
        // Determino si ese usuario debe ver esta cuenta corriente o no
        if (    $model->estaAsociadoACliente(Yii::app()->user->id) ||
                $model->estaAsociadoAPropietario(Yii::app()->user->id) ||
                Yii::app()->user->rol == 'superusuario') {
                    $file = Yii::app()->basePath.'/documentos/contratos/Contrato_'.$model->folio.'.jpg';
                    if (file_exists($file)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename='.basename($file));
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file));
                        ob_clean();
                        flush();
                        readfile($file);
                        exit;
                    }
                    else{
                        Yii::app()->user->setFlash('error',"No se ha subido imagen de este contrato firmado.");
                        $this->actionAdmin();
                    }
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }        
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        
        $this->layout = "column1";
        $ultimoContrato = Contrato::model()->findAll(array('order'=>'folio DESC'));
        $ultimoFolio = 0;
        if($ultimoContrato!=null){
            $ultimoFolio = (int)$ultimoContrato[0]->folio;
        }
        $folio = $ultimoFolio+1;
        // @todo: cambiar el modelo y el formulario para contratos de 1,2,3,4,5,6 meses o indefinido
        // @todo: Impedir la creación de contratos para deptos que ya tienen
        $model = new Contrato;
        $model->folio = $folio;
        $model->dia_pago = 1;
        $model->fecha_inicio = date('d/m/Y');
        $cuentaModel = new CuentaCorriente;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        $valid = false;
        if (isset($_POST['Contrato'])) {   // generando cuenta corriente asociada al contrato
            $model->attributes = $_POST['Contrato'];
            $model->monto_gastovariable = $_POST['Contrato']['monto_gastovariable'];
            $model->monto_mueble = $_POST['Contrato']['monto_mueble'];
            $model->monto_primer_mes = $_POST['Contrato']['monto_primer_mes'];
            $model->dias_primer_mes = $_POST['Contrato']['dias_primer_mes'];
            $model->monto_cheque = $_POST['Contrato']['monto_cheque'];
            $model->monto_castigado = $_POST['Contrato']['monto_castigado'];
            $model->reajusta_meses = $_POST['Contrato']['reajusta_meses'];
            $model->dia_pago = $_POST['Contrato']['dia_pago'];
            $model->fecha_inicio = Tools::fixFecha($model->fecha_inicio);
            $model->vigente = 1;
            $model->reajusta = 1;
            $valid = $model->validate();
            if ($valid) {
                $cuentaModel->attributes = $_POST['CuentaCorriente'];
                $cliente = $model->cliente;
                $departamento = $model->departamento;
                $cuentaModel->nombre = str_replace("-","",$cliente->rut)."-".$departamento->propiedad->nombre." (Depto.".$departamento->numero.")";
                $model->save(FALSE);
                $cuentaModel->contrato_id = $model->id;
                $valid = $valid && $cuentaModel->validate();
                if ($valid) {
                    $cuentaModel->save(FALSE);
                    if ($valid) {
                        $model->crearDeudaMes(date('Y-m-d'));
                        $usuario = $cliente->usuario;
                        $propiedad = $departamento->propiedad;
                        //una vez que está creado el contrato, guardar la copia del docx 
                        $this->doccy->newFile($model->tipo_contrato_id.'.docx'); 
                        $this->doccy->phpdocx->assignToHeader("",""); 
                        $this->doccy->phpdocx->assignToFooter("",""); 
                        $this->doccy->phpdocx->assign("#CONTRATO_FOLIO#",$model->folio); 
                        $this->doccy->phpdocx->assign("#CONTRATO_FECHA_INICIO#",Tools::backFecha($model->fecha_inicio));
                        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_RENTA#",Tools::formateaPlata($model->monto_renta)); 
                        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_GASTO_COMUN#",Tools::formateaPlata($model->monto_gastocomun));
                        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_PRIMER_MES#",Tools::formateaPlata($model->monto_primer_mes));
                        $this->doccy->phpdocx->assign("#CONTRATO_DIAS_PRIMER_MES#",$model->dias_primer_mes); 
                        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_CHEQUE#",Tools::formateaPlata($model->monto_cheque)); 
                        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_CASTIGADO#",Tools::formateaPlata($model->monto_castigado));
                        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_MUEBLE#",Tools::formateaPlata($model->monto_mueble));
                        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_GASTO_VARIABLE#",Tools::formateaPlata($model->monto_gastovariable));
                        $this->doccy->phpdocx->assign("#CONTRATO_REAJUSTA_MESES#",$model->reajusta_meses);
                        $this->doccy->phpdocx->assign("#CONTRATO_DIA_PAGO#",$model->dia_pago);
                        $this->doccy->phpdocx->assign("#CONTRATO_PLAZO#",$model->plazo); 
                        $this->doccy->phpdocx->assign("#CLIENTE_RUT#",$cliente->rut); 
                        $this->doccy->phpdocx->assign("#CLIENTE_NOMBRE#",$usuario->nombre); 
                        $this->doccy->phpdocx->assign("#CLIENTE_APELLIDO#",$usuario->apellido);
                        $this->doccy->phpdocx->assign("#CLIENTE_EMAIL#",$usuario->email); 
                        $this->doccy->phpdocx->assign("#CLIENTE_DIRECCION#",$cliente->direccion_alternativa);
                        $this->doccy->phpdocx->assign("#CLIENTE_TELEFONO#",$cliente->telefono);
                        $this->doccy->phpdocx->assign("#CLIENTE_OCUPACION#",$cliente->ocupacion);
                        $this->doccy->phpdocx->assign("#CLIENTE_RENTA#",Tools::formateaPlata($cliente->renta));
                        $this->doccy->phpdocx->assign("#PROPIEDAD_NOMBRE#",$propiedad->nombre);
                        $this->doccy->phpdocx->assign("#PROPIEDAD_DIRECCION#",$propiedad->direccion);
                        $this->doccy->phpdocx->assign("#DEPARTAMENTO_NUMERO#",$departamento->numero);
                        $this->doccy->phpdocx->assign("#DEPARTAMENTO_MT2#",$departamento->mt2);
                        $this->doccy->phpdocx->assign("#DEPARTAMENTO_DORMITORIOS#",$departamento->dormitorios);
                        $this->doccy->phpdocx->assign("#DEPARTAMENTO_ESTACIONAMIENTOS#",$departamento->estacionamientos);
                        $this->doccy->phpdocx->assign("#DEPARTAMENTO_RENTA#",Tools::formateaPlata($departamento->renta));
                        $this->renderDocx("Contrato_".$model->folio.".docx", false); 
                        
                        $this->redirect(array('admin'));
                    } else {
                        $model->delete();
                        $cuentaModel->delete();
                        $model->addError('id', 'No fue posible crear la cuenta asociada al contrato. Intente nuevamente');
                    }
                }
                else{
                    $model->delete();
                }
            }
            if(!$valid){
                $model->fecha_inicio = Tools::backFecha($model->fecha_inicio);
            }
            
        }
        //$departamentos = Departamento::model()->getListWithoutContract();
        $propiedades = Propiedad::model()->findAll();
        
        $clientes = Cliente::model()->getList();
        $tiposContrato = TipoContrato::model()->getList();
        $this->render('create', array(
            'model' => $model,
            'ctaModel' => $cuentaModel,
            'propiedades'=>$propiedades,
            'clientes' => $clientes,
            'tiposContrato' => $tiposContrato,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        if(isset($_POST['Contrato']))
        {
            $model->attributes=$_POST['Contrato'];
            $model->propiedad_id = Departamento::model()->findByPk($model->departamento_id)->propiedad->id;
            //$model->monto_primer_mes = $_POST['Contrato']['monto_primer_mes'];
            //$model->dias_primer_mes = $_POST['Contrato']['dias_primer_mes'];
            //$model->monto_cheque = $_POST['Contrato']['monto_cheque'];
            //$model->monto_castigado = $_POST['Contrato']['monto_castigado'];
            $model->imagen=CUploadedFile::getInstance($model,'imagen');
            if($model->validate()){
                if($model->imagen != null){
                    $model->imagen->saveAs(Yii::app()->basePath.'/documentos/contratos/Contrato_'.$model->folio.'.jpg');
                    Yii::app()->user->setFlash('success','Imagen de escaneo de contrato firmado subida correctamente.');
                    $this->redirect(array('admin'));
                }
                else{
                    $model->addError("documento", "Debe ser una imagen .jpg");
                }
            }
        }
        $this->render('update', array(
            'model' => $model,
        ));
    }
    
    public function actionDownload($id) {
        $model = $this->loadModel($id);
        // Determino si ese usuario debe ver esta cuenta corriente o no
        if ($model->estaAsociadoACliente(Yii::app()->user->id) ||
                $model->estaAsociadoAPropietario(Yii::app()->user->id) ||
                Yii::app()->user->rol == 'administrativo' ||
                Yii::app()->user->rol == 'superusuario') {
                    $file = Yii::app()->basePath.'/documentos/contratos/Contrato_'.$model->folio.'.docx';
                    if (file_exists($file)) {
                        header('Content-Description: File Transfer');
                        header('Content-Type: application/octet-stream');
                        header('Content-Disposition: attachment; filename='.basename($file));
                        header('Expires: 0');
                        header('Cache-Control: must-revalidate');
                        header('Pragma: public');
                        header('Content-Length: ' . filesize($file));
                        ob_clean();
                        flush();
                        readfile($file);
                        exit;
                    }
                    else{
                        Yii::app()->user->setFlash('error',"Error: no se pudo descargar este contrato.");
                        $this->actionAdmin();
                    }
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
        /*
         // Determino si ese usuario debe ver esta cuenta corriente o no
        if (Contrato::model()->estaAsociadoCliente(Yii::app()->user->id, $id) ||
                Contrato::model()->estaAsociadoPropietario(Yii::app()->user->id, $id) ||
                Yii::app()->user->rol == 'administrativo' ||
                Yii::app()->user->rol == 'superusuario') {
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
         */
        
        
        
    }


    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        // @todo: Borrar en cascada
        $contrato = $this->loadModel($id);
        
        
        $cuenta = CuentaCorriente::model()->findByAttributes(array('contrato_id'=>$id));
        if($cuenta != null){
            $cuenta->delete();
        }            
        //borrar el docx y la imagen de este contrato
        if(file_exists(Yii::app()->basePath.'/documentos/contratos/Contrato_'.$contrato->folio.'.docx')){
            unlink(Yii::app()->basePath.'/documentos/contratos/Contrato_'.$contrato->folio.'.docx');
        }
        if(file_exists(Yii::app()->basePath.'/documentos/contratos/Contrato_'.$contrato->folio.'.jpg')){
            unlink(Yii::app()->basePath.'/documentos/contratos/Contrato_'.$contrato->folio.'.jpg');
        }
        if(file_exists(Yii::app()->basePath.'/documentos/contratos/CartaAviso_'.$contrato->folio.'.docx')){
            unlink(Yii::app()->basePath.'/documentos/contratos/CartaAviso_'.$contrato->folio.'.docx');
        }
        $contrato->delete();

        
        
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        if (Yii::app()->user->rol == 'administrativo' ||
                Yii::app()->user->rol == 'superusuario') {
            $dataProvider = new CActiveDataProvider('Contrato');
        } elseif(Yii::app()->user->rol == 'cliente') {
            $client_id = Cliente::model()->getId(Yii::app()->user->id);
            $dataProvider = new CActiveDataProvider('Contrato', array(
                'criteria' => array(                    
                    'condition' => 'cliente_id=:clienteID',
                    'params' => array(':clienteID' => $client_id),
                )
            ));
        }
        else{
            $propietario_id = Propietario::model()->getId(Yii::app()->user->id);
            $dataProvider = new CActiveDataProvider('Contrato', array(
                'criteria' => array(        
                    'join' => 'JOIN departamento d ON d.id = t.departamento_id JOIN propiedad p ON p.id = d.propiedad_id',
                    'condition' => 'propietario_id=:propietarioID',
                    'params' => array(':propietarioID' => $propietario_id),
                )
            ));
        }
        $this->render('index', array(
                'dataProvider' => $dataProvider,
            ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }
    public function actionAdminFiniquitados() {
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        $this->render('adminFiniquitados', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminAbonos() {
        
        
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        
        $meses = array();
        for($i=1;$i<=12;$i++){
            $meses[] = array('id'=>  str_pad($i, 2,"0",STR_PAD_LEFT),'nombre'=>Tools::fixMes($i));
        }
        $agnos = array();
        $agnoInicio = 2000;
        $agnoFin = (int)date('Y')+10;
        for($i=$agnoInicio;$i<$agnoFin;$i++){
            $agnos[] = array('id'=>$i,'nombre'=>$i);
        }
        
        $filtroModel = new EstadoCuentaForm();
        $filtroModel->agnoH = date('Y');
        $filtroModel->mesH = date('m');
        
        if($filtroModel->mesH == '01'){
            $filtroModel->mesD = '12';
            $filtroModel->agnoD = (int)$filtroModel->agnoH - 1;
        }
        else{
            $mes = (int)$filtroModel->mesH;
            $filtroModel->mesD = str_pad($mes-1,2,"0",STR_PAD_LEFT);
            $filtroModel->agnoD = $filtroModel->agnoH;
        }
        
        if(isset($_POST['EstadoCuentaForm'])){
            $filtroModel->attributes = $_POST['EstadoCuentaForm'];
            Yii::import('ext.phpexcel.XPHPExcel');    
            
            $objPHPExcel= XPHPExcel::createPHPExcel();
            $sheet = $objPHPExcel->getActiveSheet();
            $contrato = Contrato::model()->findByPk($filtroModel->contratoId);
            if($contrato == null){
                die;
            }
            if(!$contrato->estaAsociadoAPropietario(Yii::app()->user->id)){
                die;
            }
            $sheet->setCellValue('A1', 'Movimientos de Cliente');
            $sheet->mergeCells("A1:L1");
            $sheet->getStyle("A1")->getFont()->setSize(15);
            $sheet->setCellValue('A3', 'Nombre: ');
            $sheet->setCellValue('B3', $contrato->cliente->usuario->nombre." ".$contrato->cliente->usuario->apellido);
            $sheet->setCellValue('F3', 'Fecha Consulta: '.date('d/m/Y'));
            $sheet->setCellValue('A4', 'Propiedad: ');
            $sheet->setCellValue('B4', $contrato->departamento->propiedad->nombre);
            $sheet->setCellValue('C4', "Departamento: ");
            $sheet->setCellValue('D4', $contrato->departamento->numero);
            $sheet->getStyle("A3")->getFont()->setSize(13);
            $sheet->getStyle("B3")->getFont()->setSize(13);
            $sheet->getStyle("F3")->getFont()->setSize(13);
            $sheet->getStyle("A4")->getFont()->setSize(13);
            $sheet->getStyle("B4")->getFont()->setSize(13);
            $sheet->getStyle("C4")->getFont()->setSize(13);
            $sheet->getStyle("D4")->getFont()->setSize(13);
            
            $sheet->setCellValue('A5', "Rango de fechas consultado");
            $sheet->getStyle("A5")->getFont()->setSize(13);    
            
            $sheet->setCellValue('A6', "Desde:");
            $sheet->getStyle("A6")->getFont()->setSize(13);
            $sheet->setCellValue('B6',Tools::fixMes($filtroModel->mesD)." ".$filtroModel->agnoD);
            $sheet->getStyle("B6")->getFont()->setSize(13);
            
            $fechaDesde = $filtroModel->agnoD."-".$filtroModel->mesD."-"."01";
            
            if($filtroModel->desdeInicio == '1'){
                $sheet->setCellValue('A6', "Desde inicio del Contrato:");
                $sheet->setCellValue('B6',Tools::backFecha($contrato->fecha_inicio));
                $fechaDesde = $contrato->fecha_inicio;
            }
            if($filtroModel->desdeSaldo0 == '1'){
                $movimiento = Movimiento::model()->findByPk($contrato->cuentaCorriente->idMovUltimoSaldo0());
                if($movimiento != null){
                    $sheet->setCellValue('A6', "Desde último saldo 0:");
                    $sheet->setCellValue('B6',Tools::backFecha($movimiento->fecha));
                    $fechaDesde = $movimiento->fecha;
                }
                else{
                    $sheet->setCellValue('A6', "Desde último saldo 0:");
                    $sheet->setCellValue('B6',"No hay saldo 0 ");
                    $fechaDesde = $contrato->fecha_inicio;
                }
            }
            
            $fechaArr = explode("-",$fechaDesde);
            $filtroModel->mesD = $fechaArr[1];
            $filtroModel->agnoD = $fechaArr[0];
            
            $sheet->setCellValue('A7', "Hasta:");
            $sheet->getStyle("A7")->getFont()->setSize(13);
            $sheet->setCellValue('B7',Tools::fixMes($filtroModel->mesH)." ".$filtroModel->agnoH);
            $sheet->getStyle("B7")->getFont()->setSize(13);
            
            $sheet->setCellValue('A9', "Saldo Anterior:");
            $sheet->getStyle("A9")->getFont()->setSize(13);
            $sheet->setCellValue('B9',$contrato->cuentaCorriente->saldoAFecha($fechaDesde));
            $sheet->getStyle("B9")->getFont()->setSize(13);
            
            if($filtroModel->conDetalle == "1"){
                $sheet->setCellValue('A11', "Mes/Año");
                $sheet->setCellValue('B11', "Concepto");
                $sheet->setCellValue('C11', "Cargos");
                $sheet->mergeCells('C11:D11');
                $sheet->setCellValue('E1', "Abonos");
                $sheet->mergeCells('E11:F11');
                $sheet->setCellValue('C12', "Fecha");
                $sheet->setCellValue('D12', "Monto");
                $sheet->setCellValue('E12', "Fecha");
                $sheet->setCellValue('F12', "Monto");
                $sheet->getStyle("A11:F12")->getFont()->setBold(true);
                $j = 13;
            }
            else{
                $sheet->setCellValue('A11', "Mes/Año");
                $sheet->setCellValue('B11', "Cargos");
                $sheet->setCellValue('C11', "Abonos");
                $sheet->getStyle("A11:C11")->getFont()->setBold(true);
                $j = 12;
            }
            
            $meses = Tools::arregloMeses($filtroModel->mesD, $filtroModel->agnoD, $filtroModel->mesH, $filtroModel->agnoH);
            
            $abonos = 0;
            $cargos = 0;
            foreach($meses as $mesArr){
                $mes = $mesArr['mes'];
                $agno = $mesArr['agno'];
                $mesNombre = $mesArr['mesNombre'];
                if($filtroModel->conDetalle == "1"){
                    $sheet->setCellValue('A'.$j, $mesNombre." ".$agno);
                    $j++;
                    $movimientosMes = $contrato->cuentaCorriente->movimientosDeMes($mes, $agno);
                    foreach($movimientosMes as $movimiento){
                        $sheet->setCellValue('B'.$j, $movimiento->detalle);
                        if($movimiento->tipo == Tools::MOVIMIENTO_TIPO_CARGO){
                            $sheet->setCellValue('C'.$j, Tools::backFecha($movimiento->fecha));
                            $sheet->setCellValue('D'.$j, $movimiento->monto);
                            $cargos+=$movimiento->monto;
                        }
                        else{
                            $sheet->setCellValue('E'.$j, Tools::backFecha($movimiento->fecha));
                            $sheet->setCellValue('F'.$j, $movimiento->monto);
                            $abonos+=$movimiento->monto;
                        }
                        $j++;
                    }
                }
                else{
                    $saldoMes = $contrato->cuentaCorriente->saldoMes($mes, $agno);
                    $sheet->setCellValue('A'.$j, $mesNombre." ".$agno);
                    $sheet->setCellValue('B'.$j, $saldoMes['cargos']);
                    $sheet->setCellValue('C'.$j, $saldoMes['abonos']);
                    $j++;
                }
            }
            if($filtroModel->conDetalle == "1"){
                $sheet->setCellValue('A'.$j, "SUB TOTAL");
                $sheet->setCellValue('D'.$j, $cargos);
                $sheet->setCellValue('F'.$j, $abonos);
                $j++;
            }
            
            $saldo = $contrato->cuentaCorriente->saldoAFecha(date('Y-m-d'));
            $sheet->setCellValue('A'.($j+1), "Saldo fecha consulta: ");
            $sheet->getStyle('A'.($j+1))->getFont()->setSize(13);
            $sheet->setCellValue('B'.($j+1), $saldo);
            $sheet->getStyle('B'.($j+1))->getFont()->setSize(13);
            $color = '00FF00';
            if($saldo < 0){
                $color = 'FF0000';
            }
            $sheet->getStyle("B".($j+1))->applyFromArray(
                array(
                    'fill' => array(
                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                        'color' => array('rgb' => $color)
                    )
                )
            );
            
            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Movimientos Cliente '.$contrato->cliente->usuario->nombre.' '.$contrato->cliente->usuario->apellido.'.xls"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
            header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header ('Pragma: public'); // HTTP/1.0
            $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
            $objWriter->save('php://output');
            Yii::app()->end();
        }
               
        Yii::app()->user->returnUrl=array('//contrato/adminAbonos');
        $this->render('adminAbonos', array(
            'model' => $model,
            'filtroModel'=>$filtroModel,
            'meses'=> $meses,
            'agnos'=>$agnos,
        ));
    }
    
    public function actionAdminCargos() {
        
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        Yii::app()->user->returnUrl=array('//contrato/adminCargos');
        $this->render('adminCargos', array(
            'model' => $model,
        ));
    }
    
    public function actionAdminAvisos() {
        
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        
        
        $formato = new FormatoCartaForm();
        if(isset($_POST['FormatoCartaForm'])){
            $formato->attributes = $_POST['FormatoCartaForm'];
            if(Yii::app()->user->rol == 'propietario'){
                $contrato = Contrato::model()->findByPk($formato->contrato_id);
                if(!$contrato->estaAsociadoAPropietario(Yii::app()->user->id)){
                    throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
                }
            }
            
            $formato->attributes = $_POST['FormatoCartaForm'];
            if($formato->validate()){
                $this->crearCarta($formato);
                if(CartaAviso::enviarCarta($formato)){
                    Yii::app()->user->setFlash('success',"Carta de aviso enviada correctamente al cliente.");
                }
                else{
                    Yii::app()->user->setFlash('error',"ERROR: Carta de aviso no pudo ser enviada, reintente.");
                }
                
            }
            else{
                Yii::app()->user->setFlash('error',"ERROR: debe seleccionar un formato de carta para enviar.");
            }
        }
        $this->render('adminAvisos', array(
            'model' => $model,
            'formato'=>$formato,
        ));
    }
    
    public function actionAdminAReajustar() {
        
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        $this->render('adminAReajustar', array(
            'model' => $model,
        ));
    }
    
    public function crearCarta($formato){
        
        $contrato = Contrato::model()->findByPk($formato->contrato_id);
        $departamento = $contrato->departamento;
        $cliente = $contrato->cliente;
        $usuario = $cliente->usuario;
        $propiedad = $departamento->propiedad;
        $this->doccy->newFile('../formatoCarta/'.$formato->formato.'.docx'); 
        $this->doccy->phpdocx->assignToHeader("",""); 
        $this->doccy->phpdocx->assignToFooter("",""); 
        $this->doccy->phpdocx->assign("#CONTRATO_FOLIO#",$contrato->folio); 
        $this->doccy->phpdocx->assign("#CONTRATO_FECHA_INICIO#",Tools::backFecha($contrato->fecha_inicio));
        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_RENTA#",Tools::formateaPlata($contrato->monto_renta)); 
        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_GASTO_COMUN#",Tools::formateaPlata($contrato->monto_gastocomun));
        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_PRIMER_MES#",Tools::formateaPlata($contrato->monto_primer_mes));
        $this->doccy->phpdocx->assign("#CONTRATO_DIAS_PRIMER_MES#",$contrato->dias_primer_mes); 
        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_CHEQUE#",Tools::formateaPlata($contrato->monto_cheque)); 
        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_MUEBLE#",Tools::formateaPlata($contrato->monto_mueble));
        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_GASTO_VARIABLE#",Tools::formateaPlata($contrato->monto_gastovariable));
        $this->doccy->phpdocx->assign("#CONTRATO_MONTO_CASTIGADO#",Tools::formateaPlata($contrato->monto_castigado));
        $this->doccy->phpdocx->assign("#CONTRATO_REAJUSTA_MESES#",$contrato->reajusta_meses);
        $this->doccy->phpdocx->assign("#CONTRATO_DIA_PAGO#",$contrato->dia_pago);
        $this->doccy->phpdocx->assign("#CONTRATO_PLAZO#",$contrato->plazo); 
        $this->doccy->phpdocx->assign("#CLIENTE_RUT#",$cliente->rut); 
        $this->doccy->phpdocx->assign("#CLIENTE_NOMBRE#",$usuario->nombre); 
        $this->doccy->phpdocx->assign("#CLIENTE_APELLIDO#",$usuario->apellido);
        $this->doccy->phpdocx->assign("#CLIENTE_EMAIL#",$usuario->email); 
        $this->doccy->phpdocx->assign("#CLIENTE_DIRECCION#",$cliente->direccion_alternativa);
        $this->doccy->phpdocx->assign("#CLIENTE_TELEFONO#",$cliente->telefono);
        $this->doccy->phpdocx->assign("#CLIENTE_OCUPACION#",$cliente->ocupacion);
        $this->doccy->phpdocx->assign("#CLIENTE_RENTA#",Tools::formateaPlata($cliente->renta));
        $this->doccy->phpdocx->assign("#PROPIEDAD_NOMBRE#",$propiedad->nombre);
        $this->doccy->phpdocx->assign("#PROPIEDAD_DIRECCION#",$propiedad->direccion);
        $this->doccy->phpdocx->assign("#DEPARTAMENTO_NUMERO#",$departamento->numero);
        $this->doccy->phpdocx->assign("#DEPARTAMENTO_MT2#",$departamento->mt2);
        $this->doccy->phpdocx->assign("#DEPARTAMENTO_DORMITORIOS#",$departamento->dormitorios);
        $this->doccy->phpdocx->assign("#DEPARTAMENTO_ESTACIONAMIENTOS#",$departamento->estacionamientos);
        $this->doccy->phpdocx->assign("#DEPARTAMENTO_RENTA#",Tools::formateaPlata($departamento->renta));
        $this->renderDocx("CartaAviso_".$contrato->folio.".docx", false); 
    }
    
    public function actionDescargarCarta($id){
        
        $contrato = Contrato::model()->findByPk($id);
        $cliente = $contrato->cliente;
        $departamento = $contrato->departamento;
        
        if ((Yii::app()->user->rol == 'propietario' && $contrato->estaAsociadoAPropietario(Yii::app()->user->id)) || Yii::app()->user->rol == 'superusuario') {
            $file = Yii::app()->basePath.'/documentos/contratos/CartaAviso_'.$contrato->folio.'.docx';
            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.basename($file));
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                exit;
            }
            else{
                Yii::app()->user->setFlash('error',"Error: no se pudo descargar esta carta de aviso. Para descargarla, debe haberla enviado al menos a un cliente.");
                $this->redirect(CController::createUrl("//contrato/adminAvisos"));
            }
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
    }
    
    
    public function actionAdminAviso() {
        
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        $formato = new FormatoCartaForm();
        if(isset($_POST['FormatoCartaForm'])){
            $formato->attributes = $_POST['FormatoCartaForm'];
            if(Yii::app()->user->rol == 'propietario'){
                $contrato = Contrato::model()->findByPk($formato->contrato_id);
                $propietario_id = Propietario::model()->getId(Yii::app()->user->id);
                if(!$contrato->estaAsociadoAPropietario($propietario_id)){
                    throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
                }
            }
            
            $formato->attributes = $_POST['FormatoCartaForm'];
            if($formato->validate()){
                $this->crearCarta($formato);
                if(CartaAviso::enviarCarta($formato)){
                    Yii::app()->user->setFlash('success',"Carta de aviso enviada correctamente al cliente.");
                }
                else{
                    Yii::app()->user->setFlash('error',"ERROR: Carta de aviso no pudo ser enviada, reintente.");
                }
                
            }
            else{
                Yii::app()->user->setFlash('error',"ERROR: debe seleccionar un formato de carta para enviar.");
            }
            
        }
        $this->render('//cartaAviso/admin', array(
            'model' => $model,
            'formato'=>$formato,
        ));
    }
    
    public function actionAdminReajustes() {
        $model = new Contrato('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Contrato']))
            $model->attributes = $_GET['Contrato'];

        $this->render('//debePagar/admin', array(
            'model' => $model,
        ));
    }
    
    public function actionGetNombreCliente(){
        if(isset($_POST['contrato_id'])){
            $contrato_id = $_POST['contrato_id'];
            $contrato = Contrato::model()->findByPk($contrato_id);
            if($contrato != null){
                echo $contrato->cliente->usuario->nombre." ".$contrato->cliente->usuario->apellido;
            }
        }else{
            echo "ERROR";
        }
        return;
    }


    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Contrato::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'contrato-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportarXLS() {
        // generate a resultset
        $data = Contrato::model()->with(array('departamento','cliente','tipoContrato'))->findAll();
        $this->toExcel($data, array('folio', 'fecha_inicio', 'monto_renta', 'monto_gastocomun','monto_castigado', 'plazo','departamento.numero','cliente.rut','tipoContrato.nombre'), 'Contratos', array()
        );
    }

}
