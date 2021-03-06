<?php

class TipoContratoController extends Controller
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
			array('allow',
                'actions' => array( 'view','create', 'exportarXLS','delete', 'view', 'admin'),
                'roles' => array('superusuario'),
            ),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
            $model = $this->loadModel($id);
            $file = Yii::app()->basePath.'/documentos/tipoContrato/'.$id.'.docx';

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename='.$model->nombre.'.docx');
                header('Expires: 0');
                header('Cache-Control: must-revalidate');
                header('Pragma: public');
                header('Content-Length: ' . filesize($file));
                ob_clean();
                flush();
                readfile($file);
                exit;
            }
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new TipoContrato;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['TipoContrato']))
		{
			$model->attributes=$_POST['TipoContrato'];
                        $model->documento=CUploadedFile::getInstance($model,'documento');
			if($model->validate()){
                            if($model->documento != null){
                                if(!is_dir(Yii::app()->basePath.'/documentos/tipoContrato')){
                                    mkdir(Yii::app()->basePath.'/documentos/tipoContrato');
                                }
                                $model->save();
                                $model->documento->saveAs(Yii::app()->basePath.'/documentos/tipoContrato/'.$model->id.'.docx');
                                $this->redirect(array('admin'));
                            }
                        }
                        else{
                            $model->addError("documento", "Debe ser un documento válido y con información");
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

		if(isset($_POST['TipoContrato']))
		{
			$model->attributes=$_POST['TipoContrato'];
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
            
            if(is_file(Yii::app()->basePath.'/documentos/'.Tools::CONTRATO.'/'.$model->id.'.docx')){
                unlink(Yii::app()->basePath.'/documentos/'.Tools::CONTRATO.'/'.$model->id.'.docx');
            }
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('TipoContrato');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new TipoContrato('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['TipoContrato']))
			$model->attributes=$_GET['TipoContrato'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=TipoContrato::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='tipo-contrato-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionExportarXLS()
	{
		// generate a resultset
		$data = TipoContrato::model()->findAll();
		$this->toExcel($data,
			array('nombre'),
			'Tipos de Contrato',
			array()
		);
	}
}
