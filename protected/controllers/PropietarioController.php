
<?php

class PropietarioController extends Controller
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
				'actions'=>array('view','admin','create','update','exportarXLS'),
				'roles'=>array('administrativo','superusuario'),
			),
                        array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('delete'),
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
		$model=new Propietario;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
                
		if(isset($_POST['Propietario']))
		{
			$model->attributes=$_POST['Propietario'];
                        $usuario = new Usuario();
                        $model->rut = Tools::removeDots($model->rut);
                        $usuario->user = $model->rut;
                        $arr = explode("-",$model->rut);
                        $usuario->clave = CPasswordHelper::hashPassword($arr[0]);
			
                        $usuario->rol = "propietario";
                        $usuario->nombre = $_POST['Propietario']['nombre'];
                        $usuario->email = $_POST['Propietario']['email'];
                        $usuario->apellido = $_POST['Propietario']['apellido'];
                        $model->usuario_id = 1;
                        if($model->validate()){
                            if($usuario->validate()){
                                if($usuario->save()){
                                    $model->usuario_id = $usuario->id;
                                    if($model->save()){
                                        $auth=Yii::app()->authManager;
                                        Authassignment::model()->deleteAllByAttributes(array('userid'=>$usuario->id));
                                        $auth->revoke($usuario->rol,$model->usuario_id);
                                        $auth->assign($usuario->rol,$model->usuario_id);
                                        $this->redirect(array('view','id'=>$model->id));
                                    }
                                }
                            }
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

		if(isset($_POST['Propietario']))
		{
			$model->attributes=$_POST['Propietario'];
                        $usuario = Usuario::model()->findByPk($model->usuario_id);
                        if($usuario != null){
                            $usuario->nombre = $_POST['Propietario']['nombre'];
                            $usuario->apellido = $_POST['Propietario']['apellido'];
                            $usuario->email = $_POST['Propietario']['email'];
                            if($model->validate()){
                                if($usuario->validate()){
                                    if($model->save()){
                                        $usuario->save();
                                        $this->redirect(array('view','id'=>$model->id));
                                    }
                                }
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
		$dataProvider=new CActiveDataProvider('Propietario');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Propietario('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Propietario']))
			$model->attributes=$_GET['Propietario'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Propietario the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Propietario::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Propietario $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='propietario-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
    function actionExportarXLS()
	{
		// generate a resultset
		$data=Propietario::model()->with('usuario')->findAll();

                $this->toExcel($data,
			array('rut','usuario.nombre','usuario.apellido','usuario.email','direccion'),
			'Propietario',
			array()
		);
	}
}
