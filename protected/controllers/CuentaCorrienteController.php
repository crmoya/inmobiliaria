<?php

class CuentaCorrienteController extends Controller {

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

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
                'actions' => array( 'view','send','getSaldo'),
                'roles' => array('propietario', 'superusuario'),
            ),
            array('allow',
                'actions' => array('admin','view','update', 'exportarXLS','adminMorosos','planillaIngresos','ingresosCliente'),
                'roles' => array('propietario', 'superusuario'),
            ),
            array('allow',
                'actions' => array('delete', 'admin'),
                'roles' => array('superusuario'),
            ),
            array('deny', // deny all users
                'users' => array('*'),
            ),
        );
    }
    
    public function actionGetSaldo(){
        if(isset($_POST['cuenta_id'])){
            $cuenta = CuentaCorriente::model()->findByPk($_POST['cuenta_id']);
            if($cuenta != null){
                echo number_format($cuenta->saldoAFecha(date('Y-m-d')),0,',','.');
            }
            else{
                echo '0';
            }
        }
        else{
            echo "0";
        }
    }
    
    public function actionPlanillaIngresos(){
        $model = new IngresosForm();
        $propiedades = Propiedad::model()->getDeUsuario(Yii::app()->user->id);
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
        
        $model->agnoH = date('Y');
        $model->mesH = date('m');
        
        if($model->mesH == '01'){
            $model->mesD = '12';
            $model->agnoD = (int)$model->agnoH - 1;
        }
        else{
            $mes = (int)$model->mesH;
            $model->mesD = str_pad($mes-1,2,"0",STR_PAD_LEFT);
            $model->agnoD = $model->agnoH;
        }
        
        if (isset($_POST['IngresosForm'])){
            
            $model->attributes = $_POST['IngresosForm'];
            $propiedad = Propiedad::model()->findByPk($model->propiedad_id);
            if($propiedad!=null){
                Yii::import('ext.phpexcel.XPHPExcel');    
                $objPHPExcel= XPHPExcel::createPHPExcel();
                $sheet = $objPHPExcel->getActiveSheet();
                $sheet->setCellValue('A1', 'Planilla de Ingresos por Propiedad');
                $sheet->mergeCells("A1:K1");
                $sheet->getStyle("A1")->getFont()->setSize(20);
                $sheet->setCellValue('A2', 'Propiedad: '.$propiedad->nombre);
                $sheet->mergeCells("A2:K2");
                $sheet->setCellValue('A3', 'Rango de Fechas: Desde '.Tools::fixMes($model->mesD)." de ".$model->agnoD." hasta ".Tools::fixMes($model->mesH)." de ".$model->agnoH);
                $sheet->mergeCells("A3:K3");
                $sheet->getStyle("A2")->getFont()->setSize(15);
                $sheet->getStyle("A3")->getFont()->setSize(15);

                $i = 5;

                $sheet->setCellValue('A'.$i, 'Departamento');
                $meses = Tools::arregloMeses($model->mesD, $model->agnoD, $model->mesH, $model->agnoH);
                
                $sheet->getStyleByColumnAndRow(0,$i)->getFont()->setBold(true);
                $j = 2;
                if($model->abonosYCargos == "1"){
                    $j = 1;
                }
                foreach($meses as $mesArr){
                    $sheet->setCellValueByColumnAndRow($j, $i, $mesArr['mesNombre']." de ".$mesArr['agno']);
                    $sheet->getStyleByColumnAndRow($j,$i)->getFont()->setBold(true);
                    $j++;
                }
                $i++;

                $departamentos = Departamento::model()->findAllByAttributes(array('propiedad_id'=>$propiedad->id));
                foreach($departamentos as $departamento){
                    $j=0;
                    $sheet->setCellValueByColumnAndRow($j,$i, $departamento->numero);
                    $sheet->getStyleByColumnAndRow($j,$i)->getFont()->setBold(true);
                    if($model->abonosYCargos){
                        $j++;
                        $sheet->setCellValueByColumnAndRow($j, $i, "Cargos");
                        $sheet->setCellValueByColumnAndRow($j, $i+1, "Abonos");
                        $sheet->getStyleByColumnAndRow($j,$i,$j,$i+1)->getFont()->setBold(true);
                        $j++;
                    }
                    else{
                        $j = 1;
                    }
                    if($departamento->contrato != null){
                        if($departamento->contrato->cuentaCorriente != null){
                            foreach($meses as $mesArr){
                                $saldoMes = $departamento->contrato->cuentaCorriente->saldoMes($mesArr['mes'],$mesArr['agno']);
                                if($model->abonosYCargos){
                                    $sheet->setCellValueByColumnAndRow($j, $i, $saldoMes['cargos']);
                                    $sheet->setCellValueByColumnAndRow($j, $i+1, $saldoMes['abonos']);
                                }
                                else{
                                    $sheet->setCellValueByColumnAndRow($j, $i, $saldoMes['abonos']);
                                }
                                $j++;
                            }
                        }
                    }
                    if($model->abonosYCargos){
                        $i+=2;
                    }
                    else{
                        $i++;
                    }
                }
                $objPHPExcel->setActiveSheetIndex(0);

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Movimientos Propietario.xls"');
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
                $model->addError("propiedad_id", "ERROR: Por favor seleccione propiedad válida.");
            }
        }
        $this->render('planillaIngresos', array(
            'model' => $model,
            'meses'=>$meses,
            'agnos'=>$agnos,
            'propiedades'=>$propiedades,
        ));
    }
    
    public function actionIngresosCliente(){
        $model = new IngresosClienteForm();
        $propiedades = Propiedad::model()->getDeUsuario(Yii::app()->user->id);
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
        
        $model->agnoH = date('Y');
        $model->mesH = date('m');
        
        if($model->mesH == '01'){
            $model->mesD = '12';
            $model->agnoD = (int)$model->agnoH - 1;
        }
        else{
            $mes = (int)$model->mesH;
            $model->mesD = str_pad($mes-1,2,"0",STR_PAD_LEFT);
            $model->agnoD = $model->agnoH;
        }
        
        if (isset($_POST['IngresosClienteForm'])){
            
            $model->attributes = $_POST['IngresosClienteForm'];

            Yii::import('ext.phpexcel.XPHPExcel');    
            $objPHPExcel= XPHPExcel::createPHPExcel();
            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->setCellValue('A1', 'Planilla de Ingresos de Cliente');
            $sheet->mergeCells("A1:K1");
            $sheet->getStyle("A1")->getFont()->setSize(20);
            $sheet->setCellValue('A2', 'Rango de Fechas: Desde '.Tools::fixMes($model->mesD)." de ".$model->agnoD." hasta ".Tools::fixMes($model->mesH)." de ".$model->agnoH);
            $sheet->mergeCells("A2:K2");
            $sheet->getStyle("A2")->getFont()->setSize(15);

            $i = 4;

            $sheet->setCellValue('A'.$i, 'Fecha');
            $sheet->setCellValue('B'.$i, 'Propiedad');
            $sheet->setCellValue('C'.$i, 'Departamento');
            $sheet->setCellValue('D'.$i, 'Nombre');
            $sheet->setCellValue('E'.$i, 'Monto');

            $sheet->getStyleByColumnAndRow(0,$i,4,$i)->getFont()->setBold(true);
            
            $fDesde = $model->agnoD."-".str_pad($model->mesD,2,"0",STR_PAD_LEFT)."-01";
            $fHasta = $model->agnoH."-".str_pad($model->mesH,2,"0",STR_PAD_LEFT)."-01";
            $i++;
            $movimientos = Movimiento::model()->getIngresosDePropietarioEntreFechas(Yii::app()->user->id,$fDesde,$fHasta);
            foreach($movimientos as $movimiento){
                $sheet->setCellValue('A'.$i, Tools::backFecha($movimiento->fecha));
                $sheet->setCellValue('B'.$i, $movimiento->cuentaCorriente->contrato->departamento->propiedad->nombre);
                $sheet->setCellValue('C'.$i, $movimiento->cuentaCorriente->contrato->departamento->numero);
                $sheet->setCellValue('D'.$i, $movimiento->cuentaCorriente->contrato->cliente->usuario->nombre." ".$movimiento->cuentaCorriente->contrato->cliente->usuario->apellido." (".$movimiento->cuentaCorriente->contrato->cliente->rut.")");
                $sheet->setCellValue('E'.$i, $movimiento->monto);
                $i++;
            }
            

/*                $meses = Tools::arregloMeses($model->mesD, $model->agnoD, $model->mesH, $model->agnoH);

            $sheet->getStyleByColumnAndRow(0,$i)->getFont()->setBold(true);
            $j = 2;
            if($model->abonosYCargos){
                $j = 1;
            }
            foreach($meses as $mesArr){
                $sheet->setCellValueByColumnAndRow($j, $i, $mesArr['mesNombre']." de ".$mesArr['agno']);
                $sheet->getStyleByColumnAndRow($j,$i)->getFont()->setBold(true);
                $j++;
            }
            $i++;

            $departamentos = Departamento::model()->findAllByAttributes(array('propiedad_id'=>$propiedad->id));
            foreach($departamentos as $departamento){
                $j=0;
                $sheet->setCellValueByColumnAndRow($j,$i, $departamento->numero);
                $sheet->getStyleByColumnAndRow($j,$i)->getFont()->setBold(true);
                if($model->abonosYCargos){
                    $j++;
                    $sheet->setCellValueByColumnAndRow($j, $i, "Cargos");
                    $sheet->setCellValueByColumnAndRow($j, $i+1, "Abonos");
                    $sheet->getStyleByColumnAndRow($j,$i,$j,$i+1)->getFont()->setBold(true);
                    $j++;
                }
                else{
                    $j = 1;
                }
                if($departamento->contrato != null){
                    if($departamento->contrato->cuentaCorriente != null){
                        foreach($meses as $mesArr){
                            $saldoMes = $departamento->contrato->cuentaCorriente->saldoMes($mesArr['mes'],$mesArr['agno']);
                            if($model->abonosYCargos){
                                $sheet->setCellValueByColumnAndRow($j, $i, $saldoMes['cargos']);
                                $sheet->setCellValueByColumnAndRow($j, $i+1, $saldoMes['abonos']);
                            }
                            else{
                                $sheet->setCellValueByColumnAndRow($j, $i, $saldoMes['abonos']);
                            }
                            $j++;
                        }
                    }
                }
                if($model->abonosYCargos){
                    $i+=2;
                }
                else{
                    $i++;
                }
            }
* 
* 
*/
            $objPHPExcel->setActiveSheetIndex(0);

            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="Movimientos Propietario.xls"');
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
        $this->render('ingresosCliente', array(
            'model' => $model,
            'meses'=>$meses,
            'agnos'=>$agnos,
            'propiedades'=>$propiedades,
        ));
    }
    
    public function actionAdminMorosos() {
        $model = new TempMorosos('search');
        $model->refrescar();
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['TempMorosos'])){
            $model->attributes = $_GET['TempMorosos'];
        }
        $this->render('adminMorosos', array(
            'model' => $model,
        ));
    }
    
    

    public function actionSend(){
        $body = $_POST['body'];
        $cuenta = CuentaCorriente::model()->findByPk($_POST['cuenta']);
        if($cuenta != null){
            if($cuenta->estaAsociadoPropietario(Yii::app()->user->id)){
                $message = $body;
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
                $headers .= 'From: <'.Tools::FROM_CARTA_AVISO.'>' . "\r\n";
                $headers .= 'Cc: '.Tools::FROM_CARTA_AVISO. "\r\n";
                if(mail($cuenta->contrato->cliente->usuario->email,"AVISO: ABONO A LA CUENTA CORRIENTE.",$message,$headers)){
                    echo "E-MAIL enviado correctamente.";
                }
                else{
                    echo "ERROR, por favor reintente.";
                }
            }
            else{
                echo "ERROR: No tiene permisos para enviar esta información.";
                die;
            }
        }
        else{
            echo "ERROR: No existe la cuenta corriente.";
            die;
        }
        
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
        
        if(Yii::app()->user->rol == 'cliente'){
            if (CuentaCorriente::model()->isOwnerClient(Yii::app()->user->id, $id)) {
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

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionCreate() {
       //@todo: Propietario debe poder crear nuevas cuentas ESTA FALLANDO
        $model = new CuentaCorriente;
        $modelProp = new CuentaCorrientePropietario;
        $prop_id = -1;
        if (Yii::app()->user->rol == 'propietario') {
                $prop_id = Propietario::model()->find('usuario_id=:id', array(':id' => Yii::app()->user->id))->id;
            }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if (isset($_POST['CuentaCorriente'], $_POST['CuentaCorrientePropietario'])) {
            $model->attributes = $_POST['CuentaCorriente'];
            $modelProp->attributes = $_POST['CuentaCorrientePropietario'];
            if (Yii::app()->user->rol == 'propietario') {
                $modelProp->propietario_id = $prop_id;
            }

            $modelProp->cuenta_corriente_id = -1; // valor temporal para pasar la validacion


            $valid = $model->validate();
            $valid = $modelProp->validate() && $valid;
            if ($valid) {

                $model->save(false);
                $modelProp->cuenta_corriente_id = $model->id;
                $modelProp->save(false);
                $this->redirect(array('view', 'id' => $model->id));
            }
        }
        $propietarios = Propietario::model()->getPropietariosWithRut();
        $this->render('create', array(
            'model' => $model,
            'propModel' => $modelProp,
            'propietarios' => $propietarios,
            'prop' => $prop_id,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id) {
        // Determino si ese usuario debe ver esta cuenta corriente o no
        if (CuentaCorrientePropietario::model()->isOwner(Yii::app()->user->id, $id) ||
                Yii::app()->user->rol == 'superusuario') {
            $model = $this->loadModel($id);
            $modelProp = CuentaCorrientePropietario::model()->find('cuenta_corriente_id=:cc_id', array('cc_id' => $id));
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if($modelProp!=null){
                if (isset($_POST['CuentaCorriente'], $_POST['CuentaCorrientePropietario'])) {
                    
                    $model->attributes = $_POST['CuentaCorriente'];
                    $modelProp->attributes = $_POST['CuentaCorrientePropietario'];

                    $valid = $model->validate();
                    $valid = $modelProp->validate() && $valid;
                    
                    if ($valid) {

                        $model->save(false);
                        $modelProp->save(false);
                        $this->redirect(array('view', 'id' => $model->id));
                    }
                }
            }
            

            $propietarios = Propietario::model()->getPropietariosWithRut();
            
            $this->render('create', array(
                'model' => $model,
                'propModel' => $modelProp,
                'propietarios' => $propietarios,
            ));
        } else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id) {
        // Determino si ese usuario debe ver esta cuenta corriente o no
        if (CuentaCorrientePropietario::model()->isOwner(Yii::app()->user->id, $id) ||
                Yii::app()->user->rol == 'superusuario') {
            $this->loadModel($id)->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if (!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
        }
        else {
            throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
        }
    }

    /**
     * Lists all models.
     */
    public function actionIndex() {
        // @todo: ver que pasa en el caso del rol administrativo
        // Se selecciona el dataProvider adecuado para cada rol
        if (Yii::app()->user->rol == 'propietario') { // propietario
            $prop_id = Propietario::model()->getId(Yii::app()->user->id);
            $dataProvider = new CActiveDataProvider('CuentaCorriente', array(
                'criteria' => array(
                    'join' => 'JOIN cuenta_corriente_propietario ON cuenta_corriente_propietario.cuenta_corriente_id = t.id',
                    'condition' => 'cuenta_corriente_propietario.propietario_id=:propID',
                    'params' => array(':propID' => $prop_id),
                )
            ));
        }
        if (Yii::app()->user->rol == 'superusuario' ||
                Yii::app()->user->rol == 'administrativo') { // superusuario o administrativo
            $dataProvider = new CActiveDataProvider('CuentaCorriente');
        }
        if (Yii::app()->user->rol == 'cliente') { // cliente
            $client_id = Cliente::model()->getId(Yii::app()->user->id);
            $dataProvider = new CActiveDataProvider('CuentaCorriente', array(
                'criteria' => array(
                    'join' => 'JOIN cuenta_corriente_cliente ccc ON ccc.cuenta_corriente_id = t.id JOIN contrato c ON ccc.contrato_id = c.id',
                    'condition' => 'c.cliente_id=:clienteID',
                    'params' => array(':clienteID' => $client_id),
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
        $model = new CuentaCorriente('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['CuentaCorriente']))
            $model->attributes = $_GET['CuentaCorriente'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer the ID of the model to be loaded
     */
    public function loadModel($id) {
        $model = CuentaCorriente::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel the model to be validated
     */
    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'cuenta-corriente-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionExportarXLS() {
        // generate a resultset
        $morosos = Yii::app()->user->getState('morososFiltrados');
        Yii::import('ext.phpexcel.XPHPExcel');    
        $objPHPExcel= XPHPExcel::createPHPExcel();
        $sheet = $objPHPExcel->getActiveSheet();
        $sheet->setCellValue('A1', 'Clientes Morosos');
        $sheet->mergeCells("A1:K1");
        $sheet->getStyle("A1")->getFont()->setSize(20);
            
        $filtros = "";
        if($morosos->propiedad != ""){
            $filtros .= " Propiedad: ".$morosos->propiedad.".";
        }
        if($morosos->departamento != ""){
            $filtros .= " Departamento: ".$morosos->departamento.".";
        }
        if($morosos->nombre_ap != ""){
            $filtros .= " Nombre Cliente: ".$morosos->nombre_ap.".";
        }
        if($morosos->fecha != ""){
            $filtros .= " Fecha: ".$morosos->fecha.".";
        }
        if($morosos->dias != ""){
            $filtros .= " Días de mora: ".$morosos->dias.".";
        }
        $i = 3;
        if($filtros != ""){
            $sheet->setCellValue('A2', 'Criterios de búsqueda aplicados: '.$filtros);
            $sheet->mergeCells("A2:K2");
            $i++;
            $criteria = new CDbCriteria();
            $criteria->compare('id',$morosos->id);
            if($morosos->nombre_ap != ""){
                $arreglo = explode(" ",$morosos->nombre_ap);
                $nombreApellido = array();
                foreach($arreglo as $palabra){
                    if(trim($palabra)!= ''){
                        $nombreApellido[]=$palabra;
                    }
                }
                $criteriaNombre = new CDbCriteria();
                $palabras = count($nombreApellido);
                if($palabras == 1){
                    $busqueda = $nombreApellido[0];
                    if(trim($busqueda) != ''){
                        $criteriaNombre->compare('nombre',$busqueda,true);
                        $criteriaNombre->compare('apellido',$busqueda,true,'OR');
                    }
                }

                if($palabras == 2){
                    $nombre = $nombreApellido[0];
                    $apellido = $nombreApellido[1];
                    $criteriaNombre->compare('nombre',$nombre,true);
                    $criteriaNombre->compare('apellido',$apellido,true);
                }
                $criteria->mergeWith($criteriaNombre,'AND');
            }
            
            if($morosos->propiedad != ""){
                $criteria->compare('propiedad',$morosos->propiedad,true);
            }
            if($morosos->departamento !=""){
                $criteria->compare('departamento',$morosos->departamento,true);
            }
            if($morosos->monto != ""){
                $criteria->compare('monto',$morosos->monto);
            }
            if($morosos->fecha != ""){
                $criteria->compare('fecha',Tools::fixFecha($morosos->fecha));
            }
            if($morosos->dias != ""){
                $criteria->compare('dias',$morosos->dias);
            }
            $tempMorosos = TempMorosos::model()->findAll($criteria);            
        }
        else{
            $tempMorosos = TempMorosos::model()->findAll();
        }
        
        $sheet->setCellValue('A'.$i, 'Propiedad');
        $sheet->setCellValue('B'.$i, 'Departamento');
        $sheet->setCellValue('C'.$i, 'Nombre');
        $sheet->setCellValue('D'.$i, 'Monto');
        $sheet->setCellValue('E'.$i, 'Fecha');
        $sheet->setCellValue('F'.$i, 'Dias');
        
        $sheet->getStyle("A$i:F$i")->getFont()->setBold(true);
        $i++;
        foreach($tempMorosos as $moroso){
            $sheet->setCellValue('A'.$i, $moroso->propiedad);
            $sheet->setCellValue('B'.$i, $moroso->departamento);
            $sheet->setCellValue('C'.$i, $moroso->nombre." ".$moroso->apellido);
            $sheet->setCellValue('D'.$i, $moroso->monto);
            $sheet->setCellValue('E'.$i, Tools::backFecha($moroso->fecha));
            $sheet->setCellValue('F'.$i, $moroso->dias);
            $i++;
        }
            
        $objPHPExcel->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Movimientos Propietario.xls"');
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

}
