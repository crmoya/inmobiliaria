<?php

class ClienteController extends Controller
{
    
        public function behaviors()
        {
            return array(
                'eexcelview'=>array(
                    'class'=>'ext.eexcelview.EExcelBehavior',
                ),
            );
        }
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';

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
				'actions'=>array('cartaAviso','view','admin','create','update','delete','exportarXLS','delete'),
				'roles'=>array('superusuario','propietario'),
			),
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('admin'),
				'roles'=>array('propietario'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

        public function actionCartaAviso($id)
        {
            
            $this->render('cartaAviso',array(
                'cliente'=>$this->loadModel($id),
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
		$model=new Cliente;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Cliente']))
		{
			$model->attributes=$_POST['Cliente'];
                        $model->direccion_alternativa = $_POST['Cliente']['direccion_alternativa'];
                        $usuario = new Usuario();
                        $model->rut = Tools::removeDots($model->rut);
                        $usuario->user = $model->rut;
                        $arr = explode("-",$model->rut);
                        $usuario->clave = CPasswordHelper::hashPassword($arr[0]);
                        $usuario->rol = "cliente";
                        $usuario->nombre = $_POST['Cliente']['nombre'];
                        $usuario->email = $_POST['Cliente']['email'];
                        $usuario->apellido = $_POST['Cliente']['apellido'];
                        $model->usuario_id = 1;
                        
                        
                                               
                        if($model->validate()){
                            
                            if($usuario->validate()){
                                
                                if($usuario->save()){
                                    $model->usuario_id = $usuario->id;
                                    if($model->save()){
                                        $ok = false;
                                        $auth=Yii::app()->authManager;
                                        Authassignment::model()->deleteAllByAttributes(array('userid'=>$usuario->id));
                                        $auth->revoke($usuario->rol,$model->usuario_id);
                                        $auth->assign($usuario->rol,$model->usuario_id);
                                        $fiador = new Fiador();
                                        if(isset($_POST['Cliente']['fiador_rut'])){
                                            if(isset($_POST['Cliente']['fiador_rut'])){
                                                $fiador->rut = $_POST['Cliente']['fiador_rut'];
                                                $fiador->rut = Tools::removeDots($fiador->rut);
                                                $fiador->nombre = $_POST['Cliente']['fiador_nombre'];
                                                $fiador->apellido = $_POST['Cliente']['fiador_apellido'];
                                                $fiador->email = $_POST['Cliente']['fiador_email'];
                                                $fiador->telefono = $_POST['Cliente']['fiador_telefono'];
                                                $fiador->direccion = $_POST['Cliente']['fiador_direccion'];
                                                if($fiador->validate()){
                                                    if($fiador->save()){
                                                        $ok = true;
                                                    }
                                                }
                                                else{
                                                    echo "<br>";
                                                    echo CHtml::errorSummary($fiador);
                                                }
                                            }
                                        }
                                        if($ok){
                                            $cliente_fiador = new ClienteFiador();
                                            $cliente_fiador->cliente_id = $model->id;
                                            $cliente_fiador->fiador_id = $fiador->id;
                                            $cliente_fiador->save();
                                        }
                                        $this->redirect(array('view','id'=>$model->id));
                                    }
                                }
                            }
                            else{
                                echo "<br>";
                                echo CHtml::errorSummary($usuario);
                            }
                        }
                        else{
                            echo "<br>";
                            echo CHtml::errorSummary($model);
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

		if(isset($_POST['Cliente']))
		{
                    $model->attributes=$_POST['Cliente'];
                    $model->direccion_alternativa = $_POST['Cliente']['direccion_alternativa'];
                    $usuario = Usuario::model()->findByPk($model->usuario_id);
                    $cliente_fiador = null;
                    $fiador = null;
                    if($usuario!=null){
                        $usuario->nombre = $_POST['Cliente']['nombre'];
                        $usuario->apellido = $_POST['Cliente']['apellido'];
                        $usuario->email = $_POST['Cliente']['email'];
                        
                        $ok = false;
                        if(isset($_POST['Cliente']['fiador_rut'])){
                            $cliente_fiador = $model->clienteFiadors;
                            if($cliente_fiador!=null){
                                $fiador = $cliente_fiador->fiador;
                            }
                            if(isset($_POST['Cliente']['fiador_rut'])){
                                if($fiador == null){
                                    $fiador = new Fiador();
                                }
                                $fiador->rut = $_POST['Cliente']['fiador_rut'];
                                $fiador->rut = Tools::removeDots($fiador->rut);
                                $fiador->nombre = $_POST['Cliente']['fiador_nombre'];
                                $fiador->apellido = $_POST['Cliente']['fiador_apellido'];
                                $fiador->email = $_POST['Cliente']['fiador_email'];
                                $fiador->telefono = $_POST['Cliente']['fiador_telefono'];
                                $fiador->direccion = $_POST['Cliente']['fiador_direccion'];
                                if($fiador->validate()){
                                    if($fiador->save()){
                                        $ok = true;
                                    }
                                }
                                else{
                                    echo "<br>";
                                    echo CHtml::errorSummary($fiador);
                                }

                            }
                        }

                        if($model->validate()){
                            if($usuario->validate()){
                                if($usuario->save()){
                                    if($model->save()){
                                        if($ok){
                                            if($cliente_fiador == null){
                                                $cliente_fiador = new ClienteFiador();
                                            }
                                            $cliente_fiador->cliente_id = $model->id;
                                            $cliente_fiador->fiador_id = $fiador->id;
                                            $cliente_fiador->save();
                                        }
                                        $this->redirect(array('view','id'=>$model->id));
                                    }
                                }
                            }
                            else{
                                echo "<br>";
                                echo CHtml::errorSummary($usuario);
                            }
                        }
                        else{
                            echo "<br>";
                            echo CHtml::errorSummary($model);
                        }
                    }
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
                $usuario = Usuario::model()->findByPk($model->usuario_id);
                $cliente_fiador = ClienteFiador::model()->findByAttributes(array('cliente_id'=>$id));
                if($cliente_fiador != null){
                    $fiador = $cliente_fiador->fiador;
                    $cliente_fiador->delete();
                    if($fiador != null){
                        $fiador->delete();
                    }
                }
                
                $model->delete();
                Authassignment::model()->deleteAllByAttributes(array('userid'=>$usuario->id));                
                $usuario->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Cliente');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cliente('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cliente']))
			$model->attributes=$_GET['Cliente'];
                
		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cliente the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cliente::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cliente $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cliente-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        function actionExportarXLS()
	{
		// generate a resultset
		$data=Cliente::model()->with('usuario')->findAll();

                $this->toExcel($data,
			array('rut','usuario.nombre','usuario.apellido','usuario.email','direccion_alternativa','telefono','ocupacion','renta','clienteFiadors.fiador.rut','clienteFiadors.fiador.nombre','clienteFiadors.fiador.apellido','clienteFiadors.fiador.email','clienteFiadors.fiador.telefono','clienteFiadors.fiador.direccion'),
			'Cliente',
			array()
		);
	}
}
