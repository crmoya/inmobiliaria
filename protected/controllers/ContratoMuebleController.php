<?php

class ContratoMuebleController extends Controller
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
			array('allow',
                            'actions' => array('admin','create','view'),
                            'roles' => array('superusuario','propietario'),
                        ),
                        array('allow',
                            'actions' => array('admin','view'),
                            'roles' => array('cliente'),
                        ),
                        array('allow',
                            'actions' => array('delete'),
                            'roles' => array('superusuario'),
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
            $model = $this->loadModel($id);
            $file = Yii::app()->basePath.'/documentos/contratosMuebles/'.$id.'.jpg';

            if (file_exists($file)) {
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=ContratoMuebles_FolioContrato'.$model->contrato->folio.'.jpg');
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
		$model=new ContratoMueble;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ContratoMueble']))
		{
			$model->attributes=$_POST['ContratoMueble'];
                        $model->fecha_inicio=$_POST['ContratoMueble']['fecha_inicio'];
                        $model->fecha_inicio = Tools::fixFecha($model->fecha_inicio);
                        
                        $model->imagen=CUploadedFile::getInstance($model,'imagen');
			if($model->validate()){
                            if($model->imagen != null){
                                if(!is_dir(Yii::app()->basePath.'/documentos/contratosMuebles')){
                                    mkdir(Yii::app()->basePath.'/documentos/contratosMuebles');
                                }
                                $model->save();
                                $model->imagen->saveAs(Yii::app()->basePath.'/documentos/contratosMuebles/'.$model->id.'.jpg');
                                
                                //agregar el monto del mueble al contrato asociado
                                $contrato = Contrato::model()->findByPk($model->contrato_id);
                                $contrato->monto_mueble += (int)$model->monto;
                                $contrato->propiedad_id = $contrato->departamento->propiedad->id;
                                $contrato->save();
                                $this->redirect(array('admin'));
                            }
                        }
                        else{
                            $model->addError("documento", "Debe ser una imagen .JPG");
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

		if(isset($_POST['ContratoMueble']))
		{
			$model->attributes=$_POST['ContratoMueble'];
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
            $filename = Yii::app()->basePath.'/documentos/contratosMuebles/'.$id.'.jpg';
            if(file_exists($filename)){
                unlink($filename);
            }
		

                //disminuir el monto del mueble al contrato asociado
                $contrato = Contrato::model()->findByPk($model->contrato_id);
                $contrato->monto_mueble -= (int)$model->monto;
                $contrato->propiedad_id = $contrato->departamento->propiedad->id;
                $contrato->save();
                
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
		$dataProvider=new CActiveDataProvider('ContratoMueble');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new ContratoMueble('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ContratoMueble']))
			$model->attributes=$_GET['ContratoMueble'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ContratoMueble the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ContratoMueble::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ContratoMueble $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='contrato-mueble-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
