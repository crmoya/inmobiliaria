<?php

class PrestacionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

        
        public function behaviors()
        {
            return array(
                'eexcelview'=>array(
                    'class'=>'ext.eexcelview.EExcelBehavior',
                ),
            );
        }
        
	/**
	 * @return array action filters
	 */
	public function filters()
	{
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
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('view','admin','update','delete','create','exportarXLS','listado'),
				'roles'=>array('superusuario','propietario'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
        
        public function actionListado(){
            $model = new ListadoPrestacionesForm();
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

            if (isset($_POST['ListadoPrestacionesForm'])){

                $model->attributes = $_POST['ListadoPrestacionesForm'];
                $propiedad = Propiedad::model()->findByPk($model->propiedad_id);
                $departamento = Departamento::model()->findByPk($model->departamento_id);
                
                Yii::import('ext.phpexcel.XPHPExcel');    
                $objPHPExcel= XPHPExcel::createPHPExcel();
                $sheet = $objPHPExcel->getActiveSheet();
                $sheet->setCellValue('A1', 'Listado de Prestaciones por Propiedad');
                $sheet->mergeCells("A1:K1");
                $sheet->getStyle("A1")->getFont()->setSize(20);
                $sheet->setCellValue('A2', 'Rango de Fechas: Desde '.Tools::fixMes($model->mesD)." de ".$model->agnoD." hasta ".Tools::fixMes($model->mesH)." de ".$model->agnoH);
                $sheet->mergeCells("A2:K2");
                $sheet->getStyle("A2")->getFont()->setSize(15);
                
                $i=3;
                if($propiedad != null){
                    $sheet->setCellValueByColumnAndRow(0,$i, 'Propiedad: '.$propiedad->nombre);
                    $sheet->mergeCellsByColumnAndRow(0,$i,5,$i);
                    $sheet->getStyleByColumnAndRow(0,$i)->getFont()->setSize(15);
                    $i++;
                }        
                if($departamento != null && $propiedad != null){
                    $sheet->setCellValueByColumnAndRow(0,$i, 'Departamento: '.$departamento->numero);
                    $sheet->mergeCellsByColumnAndRow(0,$i,5,$i);
                    $sheet->getStyleByColumnAndRow(0,$i)->getFont()->setSize(15);
                    $i++;
                } 

                $i++;
                $sheet->setCellValueByColumnAndRow(0,$i, 'Fecha');
                $sheet->setCellValueByColumnAndRow(1,$i, 'Propiedad');
                $sheet->setCellValueByColumnAndRow(2,$i, 'Departamento');
                $sheet->setCellValueByColumnAndRow(3,$i, 'General Prop');
                $sheet->setCellValueByColumnAndRow(4,$i, 'Nro Cheque');
                $sheet->setCellValueByColumnAndRow(5,$i, 'Monto');
                $sheet->setCellValueByColumnAndRow(6,$i, 'C/S Cargo');
                $sheet->setCellValueByColumnAndRow(7,$i, 'Concepto');
                $sheet->setCellValueByColumnAndRow(8,$i, 'Maestro');
                $sheet->setCellValueByColumnAndRow(9,$i, 'Tipo Prestación');
                $sheet->getStyleByColumnAndRow(0,$i,10,$i)->getFont()->setSize(15);
                $sheet->getStyleByColumnAndRow(0,$i,10,$i)->getFont()->setBold(true);
                
                
                $i++;
                
                $prestaciones = Prestacionesadepartamentos::model()->getDePropiedadYDepartamento($propiedad,$departamento);
                foreach($prestaciones as $prestacion){
                    $sheet->setCellValueByColumnAndRow(0,$i, Tools::backFecha($prestacion->fecha));
                    $propiedad = Propiedad::model()->findByPk($prestacion->propiedad_id);
                    $departamento = Departamento::model()->findByPk($prestacion->departamento_id);
                    if($propiedad == null){
                        $propiedad = $departamento->propiedad;
                    }
                    $sheet->setCellValueByColumnAndRow(1,$i, $propiedad->nombre);
                    $sheet->setCellValueByColumnAndRow(2,$i, $departamento!=null?$departamento->numero:"SIN DEPARTAMENTO");
                    $sheet->setCellValueByColumnAndRow(3,$i, $prestacion->general_prop==1?"SÍ":"NO");
                    $sheet->setCellValueByColumnAndRow(4,$i, $prestacion->documento);
                    $sheet->setCellValueByColumnAndRow(5,$i, $prestacion->monto);
                    $sheet->setCellValueByColumnAndRow(6,$i, $prestacion->genera_cargos==1?"SÍ":"NO");
                    $sheet->setCellValueByColumnAndRow(7,$i, $prestacion->descripcion);
                    $sheet->setCellValueByColumnAndRow(8,$i, $prestacion->maestro);
                    $sheet->setCellValueByColumnAndRow(9,$i, $prestacion->tipo);
                    $i++;
                }
                $objPHPExcel->setActiveSheetIndex(0);

                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="Prestaciones a Propiedades.xls"');
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
            $this->render('listado', array(
                'model' => $model,
                'meses'=>$meses,
                'agnos'=>$agnos,
                'propiedades'=>$propiedades,
            ));
        }


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            
            $departamentos = Departamento::model()->searchPrestacion($id);
            
            $this->render('view',array(
                    'model'=>$this->loadModel($id),
                    'departamentos'=>$departamentos,
            ));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            
            $deptos=new Departamento('search');
            $deptos->unsetAttributes();  
            if(isset($_GET['Departamento']))
                $deptos->attributes=$_GET['Departamento'];
            
            $model=new Prestacion;
            $model->fecha = date('d/m/Y');
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Prestacion']))
            {
                $model->attributes=$_POST['Prestacion'];
                $model->fecha = Tools::fixFecha($model->fecha);
                $ok = true;
                $propiedad = null;
                if($model->general_prop){
                    $propiedad = Propiedad::model()->findByPk($model->propiedad_id);
                    if($propiedad==null){
                        $ok = false;
                    }
                }
                if($ok){
                    if($model->save()){
                        if($model->general_prop!="1"){
                            if(isset($_POST['chbDepartamentoId'])){
                                $cant_deptos = count($_POST['chbDepartamentoId']);
                                if($cant_deptos > 0){
                                    $monto = (int)$model->monto/$cant_deptos;
                                    foreach($_POST['chbDepartamentoId'] as $i=>$departamento){
                                        $prest_depto = new PrestacionADepartamento();
                                        $prest_depto->departamento_id = $departamento;
                                        $prest_depto->prestacion_id = $model->id;
                                        if($prest_depto->validate()){
                                            $prest_depto->save();
                                        }
                                        if($model->genera_cargos == "1"){
                                            //se crean los cargos para el depto
                                            $cargo = new Movimiento();
                                            $depto = Departamento::model()->findByPk($departamento);
                                            if($depto->contrato != null){
                                                if($depto->contrato->vigente){
                                                    $cargo->cuenta_corriente_id = $depto->contrato->cuentaCorriente->id;
                                                }
                                                else{
                                                    continue;
                                                }
                                            }
                                            else{
                                                continue;
                                            }
                                            $cargo->fecha = $model->fecha;
                                            $cargo->tipo = Tools::MOVIMIENTO_TIPO_CARGO;
                                            $cargo->monto = $monto;
                                            $cargo->detalle = "PRESTACIÓN REALIZADA: ".$model->descripcion;
                                            $cargo->validado = 1;
                                            $cargo->saldo_cuenta = $cargo->ultimoSaldo();
                                            $cargo->save();     
                                            $cargo->actualizaSaldosPosteriores(-$monto);
                                            
                                            $prestacionMovimiento = new PrestacionGeneraMovimiento;
                                            $prestacionMovimiento->prestacion_id = $model->id;
                                            $prestacionMovimiento->movimiento_id = $cargo->id;
                                            $prestacionMovimiento->save();
                                        }
                                    }
                                }
                            }
                        }
                        else{ //general_prop == "1"
                            if($model->genera_cargos == "1"){                                    
                                //se crean los cargos para el depto
                                $departamentos = Departamento::model()->getVigentesDePropiedad($propiedad->id);
                                $cant_deptos = count($departamentos);
                                if($cant_deptos != 0){
                                    $monto = (int)$model->monto/$cant_deptos;
                                    foreach($departamentos as $depto){
                                        $cargo = new Movimiento();
                                        if($depto->contrato != null){
                                            if($depto->contrato->vigente){
                                                $cargo->cuenta_corriente_id = $depto->contrato->cuentaCorriente->id;
                                            }
                                            else{
                                                continue;
                                            }
                                        }
                                        else{
                                            continue;
                                        }
                                        $cargo->fecha = $model->fecha;
                                        $cargo->tipo = Tools::MOVIMIENTO_TIPO_CARGO;

                                        $cargo->monto = $monto;
                                        $cargo->detalle = "PRESTACIÓN REALIZADA: ".$model->descripcion;
                                        $cargo->validado = 1;
                                        $cargo->saldo_cuenta = $cargo->ultimoSaldo();
                                        $cargo->save();    
                                        $cargo->actualizaSaldosPosteriores(-$monto);
                                        
                                        $prestacionMovimiento = new PrestacionGeneraMovimiento;
                                        $prestacionMovimiento->prestacion_id = $model->id;
                                        $prestacionMovimiento->movimiento_id = $cargo->id;
                                        $prestacionMovimiento->save();
                                    }
                                }                                    
                            }
                        }
                        Yii::app()->user->setFlash('success','Prestación creada correctamente.');
                        $model = new Prestacion;
                    }
                    else{
                        Yii::app()->user->setFlash('error','Error: No se pudo crear la Prestación. Reintente.');
                    }
                }else{
                    Yii::app()->user->setFlash('error','Debe seleccionar una propiedad válida.');
                }
            }

            $this->render('create',array(
                'model'=>$model,
                'departamentos'=>$deptos,
            ));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
                $model->fecha = Tools::backFecha($model->fecha);
                $deptos=new Departamento('search');
                $deptos->unsetAttributes();  
                if(isset($_GET['Departamento']))
                    $deptos->attributes=$_GET['Departamento'];

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Prestacion']))
		{
			$model->attributes=$_POST['Prestacion'];
                        $model->fecha = Tools::fixFecha($model->fecha);
			if($model->save()){
                            $movimientosPrestacion = PrestacionGeneraMovimiento::model()->findAllByAttributes(array('prestacion_id'=>$model->id));
                            foreach($movimientosPrestacion as $mov){
                                $movimiento = $mov->movimiento;
                                if($movimiento->tipo == Tools::MOVIMIENTO_TIPO_CARGO){
                                    $movimiento->actualizaSaldosPosteriores($movimiento->monto);
                                }
                                $mov->delete();
                                $movimiento->delete();
                            }
                            PrestacionADepartamento::model()->deleteAllByAttributes(array('prestacion_id'=>$model->id));
                            if(isset($_POST['chbDepartamentoId']) && !$model->general_prop){
                                $cant_deptos = count($_POST['chbDepartamentoId']);
                                if($cant_deptos!=0){
                                    $monto = (int)$model->monto/$cant_deptos;
                                }
                                foreach($_POST['chbDepartamentoId'] as $i=>$departamento){
                                    $prest_depto = new PrestacionADepartamento();
                                    $prest_depto->departamento_id = $departamento;
                                    $prest_depto->prestacion_id = $model->id;
                                    if($prest_depto->validate()){
                                            $prest_depto->save();
                                    }                                    
                                    if($model->genera_cargos == "1"){   
                                        $cargo = new Movimiento();
                                        $contrato = Contrato::model()->findByAttributes(array('departamento_id'=>$departamento,'vigente'=>1));
                                        if($contrato != null){
                                            if($contrato->vigente){
                                                $cargo->cuenta_corriente_id = $contrato->cuentaCorriente->id;
                                            }
                                            else{
                                                continue;
                                            }
                                        }
                                        else{
                                            continue;
                                        }
                                        $cargo->fecha = $model->fecha;
                                        $cargo->tipo = Tools::MOVIMIENTO_TIPO_CARGO;

                                        $cargo->monto = $monto;
                                        $cargo->detalle = "PRESTACIÓN REALIZADA: ".$model->descripcion;
                                        $cargo->validado = 1;
                                        $cargo->saldo_cuenta = $cargo->ultimoSaldo();
                                        $cargo->save();    
                                        $cargo->actualizaSaldosPosteriores(-$monto);

                                        $prestacionMovimiento = new PrestacionGeneraMovimiento;
                                        $prestacionMovimiento->prestacion_id = $model->id;
                                        $prestacionMovimiento->movimiento_id = $cargo->id;
                                        $prestacionMovimiento->save();
                                    }
                                }
                            }
                            if($model->general_prop){
                                if($model->genera_cargos == "1"){                                    
                                    //se crean los cargos para los deptos
                                    $departamentos = Departamento::model()->getVigentesDePropiedad($model->propiedad_id);
                                    $cant_deptos = count($departamentos);
                                    if($cant_deptos != 0){
                                        $monto = (int)$model->monto/$cant_deptos;
                                        foreach($departamentos as $depto){
                                            $cargo = new Movimiento();
                                            if($depto->contrato != null){
                                                if($depto->contrato->vigente){
                                                    $cargo->cuenta_corriente_id = $depto->contrato->cuentaCorriente->id;
                                                }
                                                else{
                                                    continue;
                                                }
                                            }
                                            else{
                                                continue;
                                            }
                                            $cargo->fecha = $model->fecha;
                                            $cargo->tipo = Tools::MOVIMIENTO_TIPO_CARGO;

                                            $cargo->monto = $monto;
                                            $cargo->detalle = "PRESTACIÓN REALIZADA: ".$model->descripcion;
                                            $cargo->validado = 1;
                                            $cargo->saldo_cuenta = $cargo->ultimoSaldo();
                                            $cargo->save();    
                                            $cargo->actualizaSaldosPosteriores(-$monto);

                                            $prestacionMovimiento = new PrestacionGeneraMovimiento;
                                            $prestacionMovimiento->prestacion_id = $model->id;
                                            $prestacionMovimiento->movimiento_id = $cargo->id;
                                            $prestacionMovimiento->save();
                                        }
                                    }                                    
                                }
                            }
                            $this->redirect(array('view','id'=>$model->id));
                        }
		}

		$this->render('update',array(
			'model'=>$model,
                    'departamentos'=>$deptos,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
            $prestacion = $this->loadModel($id);
            $movs = PrestacionGeneraMovimiento::model()->findAllByAttributes(array('prestacion_id'=>$prestacion->id));
            foreach($movs as $mov){
                $movimiento = $mov->movimiento;
                if($movimiento->tipo == Tools::MOVIMIENTO_TIPO_CARGO){
                    $movimiento->actualizaSaldosPosteriores($movimiento->monto);
                }
                $mov->delete();
                $movimiento->delete();
            }
            $prestacion->delete();

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                    $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Prestacion');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Prestacion('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Prestacion']))
			$model->attributes=$_GET['Prestacion'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Prestacion the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Prestacion::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Prestacion $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='prestacion-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function actionExportarXLS()
	{
		// generate a resultset
		$data = Prestacion::model()->with(array('tipoPrestacion','ejecutor'))->findAll();
		$this->toExcel($data,
			array('fecha','monto','documento','descripcion','tipoPrestacion.nombre','ejecutor.nombre','genera_cargos'),
			'Prestaciones',
			array()
		);
	}
        
        
}
