<?php

class EgresoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','view','create','update','admin','delete','listado'),
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
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Egreso;
                $model->fecha = date('d/m/Y');
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Egreso']))
		{
			$model->attributes=$_POST['Egreso'];
                        $model->fecha = Tools::backFecha($model->fecha);
			if($model->save()){
                            $this->redirect(array('admin'));
                        }
				
		}

                $conceptos = ConceptoPredefinido::model()->findAll();
                $cptos = array();
                foreach($conceptos as $concepto){
                    $cptos[] = $concepto->nombre;
                }
		$this->render('create',array(
			'model'=>$model,
                        'conceptos'=>$cptos,
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
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Egreso']))
		{
			$model->attributes=$_POST['Egreso'];
                        $model->fecha = Tools::fixFecha($model->fecha);
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}
                $conceptos = ConceptoPredefinido::model()->findAll();
                $cptos = array();
                foreach($conceptos as $concepto){
                    $cptos[] = $concepto->nombre;
                }
		$this->render('update',array(
			'model'=>$model,
                        'conceptos'=>$cptos,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Egreso');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Egreso('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Egreso']))
			$model->attributes=$_GET['Egreso'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Egreso the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Egreso::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Egreso $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='egreso-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
