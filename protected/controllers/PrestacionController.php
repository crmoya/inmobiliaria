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
				'actions'=>array('view','admin','update','delete','create','exportarXLS'),
				'roles'=>array('superusuario','propietario'),
			),
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('admin','exportarXLS'),
				'roles'=>array('superusuario'),
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
            $model->genera_cargos = 1;
            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Prestacion']))
            {
                $model->attributes=$_POST['Prestacion'];
                $model->fecha = Tools::fixFecha($model->fecha);
                
                if($model->save()){
                    
                    if(isset($_POST['chbDepartamentoId'])){
                        foreach($_POST['chbDepartamentoId'] as $i=>$departamento){
                            $prest_depto = new PrestacionADepartamento();
                            $prest_depto->departamento_id = $departamento;
                            $prest_depto->prestacion_id = $model->id;
                            if($prest_depto->validate()){
                                    $prest_depto->save();
                            }				
                        }
                    }
                    
                    $this->redirect(array('view','id'=>$model->id));
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
                            PrestacionADepartamento::model()->deleteAllByAttributes(array('prestacion_id'=>$model->id));
                            if(isset($_POST['chbDepartamentoId'])){
                                foreach($_POST['chbDepartamentoId'] as $i=>$departamento){
                                    $prest_depto = new PrestacionADepartamento();
                                    $prest_depto->departamento_id = $departamento;
                                    $prest_depto->prestacion_id = $model->id;
                                    if($prest_depto->validate()){
                                            $prest_depto->save();
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
