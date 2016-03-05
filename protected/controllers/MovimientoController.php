<?php

class MovimientoController extends Controller {

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
    public function accessRules() {
        return array(
            array('allow',
                'actions' => array( 'viewDetail', 'view','cargar','abonar','create','eliminar'),
                'roles' => array('propietario', 'superusuario'),
            ),
            array('allow',
                'actions' => array('validate','create','informe'),
                'roles' => array('propietario'),
            ),
            array('allow',
                'actions' => array('indexPerson', 'clientesDia', 'clientesMorosos'),
                'roles' => array('propietario', 'superusuario'),
            ),
            array('allow',
                'actions' => array('indexContract'),
                'roles' => array('superusuario', 'cliente',),
            ),
            array('allow',
                'actions' => array('indexType', 'create', 'update', 'validate', 'resumenMovimiento', 'reporteArriendos', 'exportarXLS'),
                'roles' => array('superusuario','propietario'),
            ),
            array('allow',
                'actions' => array('delete', 'admin'),
                'roles' => array('superusuario','propietario'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }

    
    public function actionInforme(){
        $form = new InformeForm();
        if(isset($_POST['InformeForm'])){
            $form->attributes = $_POST['InformeForm'];
            Yii::import('ext.phpexcel.XPHPExcel');    
            
            $objPHPExcel= XPHPExcel::createPHPExcel();
            $sheet = $objPHPExcel->getActiveSheet();
            $styleCenter = array(
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                )
            );

            $sheet->setCellValue('A1', 'Informe de Movimientos de Propietario');
            $sheet->getStyle("A1")->getFont()->setSize(20);
            $sheet->setCellValue('A2', 'Desde: '.$form->fechaDesde.' Hasta: '.$form->fechaHasta);
            $sheet->getStyle("A2")->getFont()->setSize(16);
            
            $fechaDesdeArr = explode('-',$form->fechaDesde);
            if(count($fechaDesdeArr)== 3){
                $mesInicio = $fechaDesdeArr[1];
                $agnoInicio = $fechaDesdeArr[0];
            }else{
                $mesInicio = date('m');
                $agnoInicio = date('Y');
                $form->fechaDesde = date('Y-m-d');
            }
          
            $fechaHastaArr = explode('-',$form->fechaHasta);
            if(count($fechaHastaArr) == 3){
                $mesFin = $fechaHastaArr[1];
                $agnoFin = $fechaHastaArr[0]; 
            }
            else{
                $mesFin = date('m');
                $agnoFin = date('Y'); 
                $form->fechaHasta = date('Y-m-d');
            }
            $meses = Tools::arregloMeses($mesInicio, $agnoInicio, $mesFin, $agnoFin);
            
            $propietario_id = Propietario::model()->getId(Yii::app()->user->id);
            $propietario = Propietario::model()->findByPk($propietario_id);
            $propiedades = Propiedad::model()->findAllByAttributes(array('propietario_id'=>$propietario_id));
            $row = 4;
            foreach($propiedades as $propiedad){
                $sheet->setCellValueByColumnAndRow(0,$row,"PROPIEDAD: ".$propiedad->nombre);
                $row++;
                foreach($propiedad->departamentos as $departamento){
                    if($departamento->contrato != null){
                        $rmax = 0;
                        $sheet->setCellValueByColumnAndRow(0,$row,"Departamento: ".$departamento->numero.", Contrato: ".$departamento->contrato->folio.", Arrendatario: ".$departamento->contrato->cliente->rut." ".$departamento->contrato->cliente->usuario->nombre." ".$departamento->contrato->cliente->usuario->apellido);
                        $row++;
                        $sheet->setCellValueByColumnAndRow(0,$row,"Movimientos de la cuenta");
                        $col=0;
                        $cuentaCorriente = $departamento->contrato->cuentaCorriente;
                        $saldo = 0;
                        foreach($meses as $mesArreglo){
                            $nDias = cal_days_in_month(CAL_GREGORIAN, $mesArreglo['mes'], $mesArreglo['agno']);
                            $sheet->mergeCellsByColumnAndRow($col,$row,$col+1,$row);
                            $sheet->getStyleByColumnAndRow($col,$row)->applyFromArray($styleCenter);
                            $sheet->setCellValueByColumnAndRow($col,$row,$mesArreglo['mesNombre']." ".$mesArreglo['agno']);
                            $sheet->setCellValueByColumnAndRow($col,$row+1,Tools::MOVIMIENTO_TIPO_ABONO);
                            $sheet->setCellValueByColumnAndRow($col+1,$row+1,Tools::MOVIMIENTO_TIPO_CARGO);
                            $movimientos = Movimiento::model()->findAll(array(
                                'condition'=>'fecha >= :fIni and fecha <= :fFin and cuenta_corriente_id = :cta',
                                'params'=>array(':fIni'=>$mesArreglo['agno']."-".$mesArreglo['mes']."-01",':fFin'=>$mesArreglo['agno']."-".$mesArreglo['mes']."-".$nDias,':cta'=>$cuentaCorriente->id)
                            ));
                            if(count($movimientos)>$rmax){
                                $rmax = count($movimientos);
                            }
                            $iMov =0;
                            while($iMov<count($movimientos)){
                                $movimiento = $movimientos[$iMov];
                                if($movimiento->tipo == Tools::MOVIMIENTO_TIPO_ABONO){
                                    if($movimiento->validado == 1){
                                        $sheet->setCellValueByColumnAndRow($col,$row+2+$iMov,$movimiento->monto);
                                        $saldo += $movimiento->monto;
                                    }
                                }
                                if($movimiento->tipo == Tools::MOVIMIENTO_TIPO_CARGO){
                                    $sheet->setCellValueByColumnAndRow($col+1,$row+2+$iMov,$movimiento->monto);
                                    $saldo -= $movimiento->monto;
                                }
                                $iMov++;
                            }
                            $sheet->mergeCellsByColumnAndRow($col,$row+2+$iMov,$col+1,$row+2+$iMov);
                            $sheet->setCellValueByColumnAndRow($col,$row+2+$iMov,$saldo);
                            $sheet->getStyleByColumnAndRow($col,$row+2+$iMov)->applyFromArray($styleCenter);
                            if($saldo < 0){
                                $sheet->getStyleByColumnAndRow($col,$row+2+$iMov)->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => 'FF0000')
                                        )
                                    )
                                );
                            }
                            else{
                                $sheet->getStyleByColumnAndRow($col,$row+2+$iMov)->applyFromArray(
                                    array(
                                        'fill' => array(
                                            'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                            'color' => array('rgb' => '0000FF')
                                        )
                                    )
                                );
                            }
                            $col+=2;
                        }
                        $row+=$rmax+1;
                    }
                }
                $row+=3;
            }
            

            // Set active sheet index to the first sheet, so Excel opens this as the first sheet
            $objPHPExcel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Movimientos Propietario '.$propietario->usuario->nombre.' '.$propietario->usuario->apellido.'.xls"');
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
        else{
            $form->fechaHasta = date('Y-m-d');
        }
        $this->render('informe',array('model'=>$form));
    }
    
    /**
     * Permite seleccionar el tipo de cuenta en la que se desea realizar
     * el movimiento
     */
    public function actionIndexType() {
        if (Yii::app()->user->rol == 'propietario') {
            $this->redirect(array('indexPerson'));
        } elseif (Yii::app()->user->rol == 'cliente') {
            $this->redirect(array('indexContract'));
        } else {
            $this->render('indexType');
        }
    }

    public function actionIndexContract() {
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/footable.core.css');
        $cs->registerScriptFile($baseUrl . '/js/footable.js');
        $cs->registerScriptFile($baseUrl . '/js/footable.paginate.js');
        if (Yii::app()->user->rol == 'cliente') {
            $user_id = Yii::app()->user->id;
            $cliente_id = Cliente::model()->getId($user_id);
            $cuentas = CuentaCorriente::model()->findAll(array(
                'join' => 'JOIN contrato c ON t.contrato_id = c.id',
                'condition' => 'c.cliente_id=:clienteID',
                'params' => array(':clienteID' => $cliente_id),
            ));
            $this->render('indexContract', array(
                'cuentas' => $cuentas,
            ));
        } else {
            $cuentas = CuentaCorriente::model()->findAll(array(
                'join' => 'JOIN contrato c ON t.contrato_id = c.id',
                'order' => 'c.cliente_id'
            ));
            $this->render('indexContract', array(
                'cuentas' => $cuentas,
            ));
        }
    }

    public function actionIndexPerson() {
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/footable.core.css');
        $cs->registerScriptFile($baseUrl . '/js/footable.js');
        $cs->registerScriptFile($baseUrl . '/js/footable.paginate.js');
        if (Yii::app()->user->rol == 'propietario') {
            $user_id = Yii::app()->user->id;
            $prop_id = Propietario::model()->getId($user_id);
            $cuentas_propietario = Propietario::model()->getCuentas($prop_id);
           
            $this->render('indexPerson', array(
                'cuentas_propietario' => $cuentas_propietario,
            ));
        } else {
            $cuentas_propietario = CuentaCorrientePropietario::model()->findAll(array(
                'order' => 'propietario_id',
            ));
            $this->render('indexPerson', array(
                'cuentas_propietario' => $cuentas_propietario,
            ));
        }
    }

    public function actionClientesDia() {
// Including js for table pagination
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/footable.core.css');
        $cs->registerScriptFile($baseUrl . '/js/footable.js');
        $cs->registerScriptFile($baseUrl . '/js/footable.paginate.js');
        $departamentos = Departamento::model()->findAll();
        $deptos_al_dia = array();
        foreach ($departamentos as $depto) {
            if ($depto->estaAlDia()) {
                $deptos_al_dia[] = $depto;
            }
        }
        $this->render('clientesDia', array(
            'departamentos' => $deptos_al_dia,
        ));
    }

    public function actionClientesMorosos() {
// Including js for table pagination
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/footable.core.css');
        $cs->registerScriptFile($baseUrl . '/js/footable.js');
        $cs->registerScriptFile($baseUrl . '/js/footable.paginate.js');
        $departamentos = Departamento::model()->findAll();
        $deptos_morosos = array();
        foreach ($departamentos as $depto) {
            if (!$depto->estaAlDia()) {
                $deptos_morosos[] = $depto;
            }
        }
        $this->render('clientesMorosos', array(
            'departamentos' => $deptos_morosos,
        ));
    }

    public function actionViewDetail($id) {
// Including js for table pagination
        $baseUrl = Yii::app()->baseUrl;
        $cs = Yii::app()->getClientScript();
        $cs->registerCssFile($baseUrl . '/css/footable.core.css');
        $cs->registerScriptFile($baseUrl . '/js/footable.js');
        $cs->registerScriptFile($baseUrl . '/js/footable.paginate.js');

        $cuenta = CuentaCorriente::model()->findByPk($id);
        if(Yii::app()->user->rol == 'propietario'){
            if($cuenta->estaAsociadoPropietario(Yii::app()->user->id)){
                $this->render('viewDetail', array(
                    'cuenta' => $cuenta,
                ));
            }
            else{
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            }
        }
        else{
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
        /*
        if(Yii::app()->user->rol == 'cliente'){
            if (CuentaCorriente::model()->isOwnerClient(Yii::app()->user->id, $id)) {
                $movs = Movimiento::model()->findAll(array(
                    'condition' => 'cuenta_corriente_id=:cuenta_corriente_id',
                    'order' => 'fecha',
                    'params' => array(':cuenta_corriente_id' => $id)));
                $cuenta = CuentaCorriente::model()->findByPk($id);
                $this->render('viewDetail', array(
                    'model' => $movs,
                    'cuenta' => $cuenta,
                ));
            } else {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            }
        }
        
        
        if(Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo'){
            $movs = Movimiento::model()->findAll(array(
                'condition' => 'cuenta_corriente_id=:cuenta_corriente_id',
                'order' => 'fecha',
                'params' => array(':cuenta_corriente_id' => $id)));
            $cuenta = CuentaCorriente::model()->findByPk($id);
            $this->render('viewDetail', array(
                'model' => $movs,
                'cuenta' => $cuenta,
            ));
        }
         * 
         */
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id) {
// Determino si ese usuario debe ver esta cuenta corriente o no
        
        if(Yii::app()->user->rol == 'propietario'){
            if (CuentaCorriente::model()->isOwnerProp(Yii::app()->user->id, $id)) {
                $this->render('view', array(
                    'model' => $this->loadModel($id),
                ));
            } else {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            }
        }
        
        
        if(Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo'){
            $this->render('view', array(
                'model' => $this->loadModel($id),
            ));
        }
        
    }

    
    public function actionCargar($id){
        $model = new Movimiento;
        $model->fecha = date('Y-m-d');
        $model->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
        $model->cuenta_corriente_id = $id;
        $model->monto = 0;
        $cta = CuentaCorriente::model()->findByPk($id);
        if($cta!=null){
            if(Yii::app()->user->rol == 'propietario'){
                if(!$cta->estaAsociadoPropietario(Yii::app()->user->id)){
                    throw new CHttpException(404, 'Error, no tiene permisos para cargar esta cuenta.');
                }
            }
            if(isset($_POST['Movimiento'])){
                $model->attributes = $_POST['Movimiento'];
                $model->validado = 1;
                if($model->save()){
                    $model = new Movimiento;
                    $model->fecha = date('Y-m-d');
                    $model->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
                    $model->cuenta_corriente_id = $id;
                    Yii::app()->user->setFlash('success','Cuenta correctamente cargada.');
                }
                else{
                    Yii::app()->user->setFlash('error','Error: No se pudo cargar la cuenta. Por favor reintente.');
                }
                
            }
        }
        else{
            throw new CHttpException(404, 'Error, no existe la cuenta a cargar.');
        }
        $this->render('cargar',array('model'=>$model));
    }
    
    public function actionAbonar($id){
        $model = new Movimiento;
        $model->fecha = date('Y-m-d');
        $model->tipo = Tools::MOVIMIENTO_TIPO_ABONO;
        $model->cuenta_corriente_id = $id;
        $model->monto = 0;
        $cta = CuentaCorriente::model()->findByPk($id);
        if($cta!=null){
            if(Yii::app()->user->rol == 'propietario'){
                if(!$cta->estaAsociadoPropietario(Yii::app()->user->id)){
                    throw new CHttpException(404, 'Error, no tiene permisos para abonar esta cuenta.');
                }
            }
            if(isset($_POST['Movimiento'])){
                $model->attributes = $_POST['Movimiento'];
                $model->forma_pago_id = $_POST['Movimiento']['forma_pago_id'];
                $model->validado = 1;
                if($model->save()){
                    $model = new Movimiento;
                    $model->fecha = date('Y-m-d');
                    $model->tipo = Tools::MOVIMIENTO_TIPO_ABONO;
                    $model->cuenta_corriente_id = $id;
                    Yii::app()->user->setFlash('success','Cuenta correctamente abonada.');
                }
                else{
                    Yii::app()->user->setFlash('error','Error: No se pudo abonar la cuenta. Por favor reintente.');
                }
                
            }
        }
        else{
            throw new CHttpException(404, 'Error, no existe la cuenta a abonar.');
        }
        $this->render('abonar',array('model'=>$model));
    }
    
    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
        $cuenta_id = $_POST['cuenta'];
        $fecha = $_POST['fecha'];
        $monto = $_POST['monto'];
        $detalle = $_POST['detalle'];
        $tipo = $_POST['tipo'];
        $forma_pago_id = -1;
        if(isset($_POST['formaPago'])){
            $forma_pago_id = $_POST['formaPago'];
        }
        
        $model = new Movimiento();
        $model->fecha = $fecha;
        $model->monto = $monto;
        $model->detalle = $detalle;
        $model->tipo = $tipo;
        if($model->tipo == Tools::MOVIMIENTO_TIPO_CARGO){
            $model->validado = 1;
        }
        else{
            $model->validado = 0;
            $model->forma_pago_id = $forma_pago_id;
        }
        $model->cuenta_corriente_id = $cuenta_id;
        $cuenta = CuentaCorriente::model()->findByPk($cuenta_id);
        if($cuenta == null){
            echo -1;
            die;
        }
        else{
            if($cuenta->estaAsociadoPropietario(Yii::app()->user->id)){
                $anterior = $model->findAllByAttributes(array('fecha'=>$model->fecha,'tipo'=>$model->tipo,'monto'=>$model->monto,'detalle'=>$model->detalle,'cuenta_corriente_id'=>$model->cuenta_corriente_id));
                if(count($anterior) == 0){
                    if($model->save()){
                        echo $model->id;
                    }
                    else{
                        echo CHtml::errorSummary($model);
                    }
                }
                die;
            }
            else{
                echo -1;
                die;
            }
        }
        
        /*$model = new Movimiento;
        $cta = CuentaCorriente::model()->findByPk($id);
        $contrato = $cta->contrato;
        $model->fecha = date('Y-m-d');
            
// Uncomment the following line if AJAX validation is needed
// $this->performAjaxValidation($model);

        if (isset($_POST['Movimiento'])) {
            $model->attributes = $_POST['Movimiento'];
            $model->forma_pago_id = $_POST['Movimiento']['forma_pago_id'];
            $model->validado = 0;
            $model->cuenta_corriente_id = $id;
            
            if ($model->save()) {
                $this->redirect(array('viewDetail', 'id' => $id));
            }
        }


        $list = null;
        $propietario_id = $cta->contrato->departamento->propiedad->propietario->id;
        $list = Propietario::model()->getAssociatedAccounts($propietario_id);
        $this->render('create', array(
            'model' => $model,
            'cuenta_cte' => $id,
            'lista_cuentas' => $list,
        ));*/
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate() {
        $mov_id = Yii::app()->request->getPost('mov_id');
        $model = $this->loadModel($mov_id);

        if (isset($_POST['Movimiento'])) {
            $model->attributes = $_POST['Movimiento'];
            if($model->tipo == Tools::MOVIMIENTO_TIPO_CARGO){
                $model->forma_pago_id = null;
            }
            if($model->cuentaCorriente->estaAsociadoPropietario(Yii::app()->user->id)){
                if ($model->save())
                    $this->redirect(array('viewDetail', 'id' => $model->cuenta_corriente_id));
            }
        }
        
        $this->render('update', array(
            'model' => $model        
        ));
    }

    public function actionEliminar(){
        $movimiento = Movimiento::model()->findByPk($_POST['mov']);
        if($movimiento!=null){
            if(Yii::app()->user->rol == 'propietario' && $movimiento->cuentaCorriente->estaAsociadoPropietario(Yii::app()->user->id)){
                $movimiento->delete();
                echo "OK";
            }
            else{
                echo "ERROR: Usted no está autorizado para realizar esta acción.";
            }
        }
        else{
            echo "ERROR: No se encuentra el movimiento a eliminar.";
        }
    }
    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete() {
        $mov_id = Yii::app()->request->getPost('mov_id');
        $cuenta_id = Yii::app()->request->getPost('cuenta_id');
        $model = $this->loadModel($mov_id);
        $model->delete();

// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('movimiento/viewDetail/' . $cuenta_id));
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        $dataProvider = new CActiveDataProvider('Movimiento');
        $this->render('index', array(
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionAdmin() {
        $model = new Movimiento('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['Movimiento']))
            $model->attributes = $_GET['Movimiento'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionResumenMovimiento() {
        $model = new ResumenMovimientoForm;

// uncomment the following code to enable ajax-based validation
        
          if(isset($_POST['ajax']) && $_POST['ajax']==='resumen-movimiento-form-resumenMovimiento-form')
          {
          echo CActiveForm::validate($model);
          Yii::app()->end();
          }
         

        if (isset($_POST['ResumenMovimientoForm'])) {
            $model->attributes = $_POST['ResumenMovimientoForm'];
            if ($model->validate()) {
                $this->redirect(array('reporteArriendos', 'inicio' => $model->inicio, 'fin' => $model->fin));
            }
        }
        $this->render('resumenMovimiento', array('model' => $model));
    }

    public function actionValidate() {
// Changing the validation state
        $mov_id = Yii::app()->request->getPost('mov_id');
        $cuenta_id = Yii::app()->request->getPost('cuenta_id');
        $mov = Movimiento::model()->findByPk($mov_id);
        
        $mov->validado = $mov->validado==0?1:0;

        $mov->save();
        $this->redirect(array('viewDetail', 'id' => $cuenta_id));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = Movimiento::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'movimiento-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportarXLS() {
// generate a resultset
        $data = Contrato::model()->findAll();
        $this->toExcel($data, array('fecha', 'tipo', 'monto', 'detalle'), 'Movimientos Cuenta Corriente', array()
        );
    }

    public function actionReporteArriendos($inicio, $fin) {
// generate a resultset
        
        $criteria=new CDbCriteria;
        $criteria->params = array(":inicio"=>$inicio, ":fin"=>$fin);
        if(!empty($inicio)){
            $criteria->addCondition("t.fecha >= :inicio");
        }
        if(!empty($fin)){
            $criteria->addCondition("t.fecha <= :fin");
        }
        $criteria->with = array('contrato.departamento','contrato.departamento.propiedad','contrato.cliente','contrato.cliente.usuario','contrato'=>array('order'=>'fecha ASC'));
        
        $data = PagoMes::model()->findAll($criteria);
        
        $this->toExcel($data, array('contrato.departamento.propiedad.nombre','contrato.departamento.numero','contrato.cliente.usuario.nombre', 'contrato.cliente.usuario.apellido', 'contrato.fecha_inicio', 'contrato.cliente.usuario.email','contrato.cliente.telefono','fecha','monto_renta','gasto_comun','monto_mueble','gasto_variable'), 'Reporte de Arriendos', array()
        );
    }

}
