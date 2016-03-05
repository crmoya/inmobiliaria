<?php

class DemandaJudicialController extends Controller
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
        
        public function behaviors() {
            return array(
                'eexcelview' => array(
                    'class' => 'ext.eexcelview.EExcelBehavior',
                ),
                'doccy' => array(
                    'class' => 'ext.doccy.Doccy',
                    'options' => array(
                        'templatePath' => Yii::app()->basePath.'/documentos/formatoDemanda/',  // Path where docx templates are stored. Default value is controller`s view folder 
                        'outputPath' => Yii::app()->basePath.'/documentos/demandas/',  // Path where output files should be stored. Default value is application runtime folder 
                        //'docxgenFolder' => 'docxgen-master',  // Name of the folder which holds docxgen library (must be in the extension folder). Default value is 'docxgen-master' 
                     ),
                ),
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
			array('allow',
                            'actions' => array( 'view','download','getNombreCliente','descargarCarta', 'admin'),
                            'roles' => array('propietario', 'superusuario', 'cliente'),
                        ),
                        array('allow',
                            'actions' => array('create', 'exportarXLS','update','adminAviso','delete'),
                            'roles' => array('superusuario'),
                        ),
                        array('allow',
                            'actions' => array('create','admin'),
                            'roles' => array('propietario'),
                        ),
                        array('deny', // deny all users
                            'users' => array('*'),
                        ),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $contrato = DemandaJudicial::model()->findByPk($id)->contrato;
            $departamento = $contrato->departamento;
            $file = Yii::app()->basePath.'/documentos/demandas/Demanda_'.$contrato->cliente->rut.'_depto'.$departamento->numero.'.docx';
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
                Yii::app()->user->setFlash('error',"No existe esta demanda.");
                $this->actionAdmin();
            }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new DemandaJudicial;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DemandaJudicial']))
		{
                                        
			$model->attributes=$_POST['DemandaJudicial'];
                        $contrato = Contrato::model()->findByPk($model->contrato_id);
                        $cliente = $contrato->cliente;
                        $usuario = $cliente->usuario;
                        $departamento = $contrato->departamento;
                        $propiedad = $departamento->propiedad;
                        
			if($model->save()){
                            $this->doccy->newFile($model->formato_demanda_id.'.docx'); 
                            $this->doccy->phpdocx->assignToHeader("",""); 
                            $this->doccy->phpdocx->assignToFooter("",""); 
                            $this->doccy->phpdocx->assign("#CONTRATO_FOLIO#",$contrato->folio); 
                            $this->doccy->phpdocx->assign("#CONTRATO_FECHA_INICIO#",Tools::backFecha($contrato->fecha_inicio));
                            $this->doccy->phpdocx->assign("#CONTRATO_MONTO_RENTA#",Tools::formateaPlata($contrato->monto_renta)); 
                            $this->doccy->phpdocx->assign("#CONTRATO_MONTO_PRIMER_MES#",Tools::formateaPlata($contrato->monto_primer_mes));
                            $this->doccy->phpdocx->assign("#CONTRATO_DIAS_PRIMER_MES#",$contrato->dias_primer_mes); 
                            $this->doccy->phpdocx->assign("#CONTRATO_MONTO_CHEQUE#",Tools::formateaPlata($contrato->monto_cheque)); 
                            $this->doccy->phpdocx->assign("#CONTRATO_MONTO_GASTO_COMUN#",Tools::formateaPlata($contrato->monto_gastocomun));
                            $this->doccy->phpdocx->assign("#CONTRATO_MONTO_MUEBLE#",Tools::formateaPlata($contrato->monto_mueble));
                            $this->doccy->phpdocx->assign("#CONTRATO_MONTO_GASTO_VARIABLE#",Tools::formateaPlata($contrato->monto_gastovariable));
                            $this->doccy->phpdocx->assign("#CONTRATO_REAJUSTA_MESES#",Tools::formateaPlata($contrato->reajusta_meses));
                            $this->doccy->phpdocx->assign("#CONTRATO_DIA_PAGO#",Tools::formateaPlata($contrato->dia_pago));
                            $this->doccy->phpdocx->assign("#CONTRATO_MONTO_CASTIGADO#",Tools::formateaPlata($contrato->monto_castigado));
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
                            $this->renderDocx("Demanda_".$cliente->rut."_depto".$departamento->numero.".docx", false); 
                            $this->redirect(array('admin'));
                        }
			
		}

		$this->render('create',array(
			'model'=>$model,
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

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['DemandaJudicial']))
		{
			$model->attributes=$_POST['DemandaJudicial'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
                $model = $this->loadModel($id);
                $contrato = $model->contrato;
                $departamento = $contrato->departamento;
                $model->delete();
		
                if(file_exists(Yii::app()->basePath.'/documentos/demandas/Demanda_'.$contrato->cliente->rut.'_depto'.$departamento->numero.'.docx')){
                    unlink(Yii::app()->basePath.'/documentos/demandas/Demanda_'.$contrato->cliente->rut.'_depto'.$departamento->numero.'.docx');
                }
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('DemandaJudicial');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new DemandaJudicial('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['DemandaJudicial']))
			$model->attributes=$_GET['DemandaJudicial'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return DemandaJudicial the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=DemandaJudicial::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param DemandaJudicial $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='demanda-judicial-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
