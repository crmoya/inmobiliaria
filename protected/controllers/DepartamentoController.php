<?php

class DepartamentoController extends Controller
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
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array( 'view','admin'),
                    'roles' => array('administrativo', 'superusuario', 'propietario','cliente'),
                ),
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('admin', 'create', 'update', 'exportarXLS'),
                    'roles' => array('administrativo', 'superusuario'),
                ),
                array('allow', // allow all users to perform 'index' and 'view' actions
                    'actions' => array('delete'),
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
            if (Departamento::model()->estaAsociadoCliente(Yii::app()->user->id, $id) ||
                Departamento::model()->estaAsociadoPropietario(Yii::app()->user->id, $id) ||
                Yii::app()->user->rol == 'administrativo' ||
                Yii::app()->user->rol == 'superusuario') {
                $this->render('view', array(
                    'model' => $this->loadModel($id),
                ));
            } else {
                throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
            }
        }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
            $model=new Departamento;

            // Uncomment the following line if AJAX validation is needed
            // $this->performAjaxValidation($model);

            if(isset($_POST['Departamento']))
            {
                    $model->attributes=$_POST['Departamento'];
                    if($model->save())
                            $this->redirect(array('view','id'=>$model->id));
            }
            $propiedades = Propiedad::model()->findAll(array('select'=>'id,nombre'));
            $this->render('create',array(
                    'model'=>$model,
                    'propiedades'=>$propiedades,
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

            if(isset($_POST['Departamento']))
            {
                    $model->attributes=$_POST['Departamento'];
                    if($model->save())
                            $this->redirect(array('view','id'=>$model->id));
            }
            $propiedades = Propiedad::model()->findAll(array('select'=>'id,nombre'));
            $this->render('update',array(
                    'model'=>$model,
                    'propiedades'=>$propiedades,
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
            if (Yii::app()->user->rol == 'administrativo' ||
                    Yii::app()->user->rol == 'superusuario') {
                $dataProvider=new CActiveDataProvider('Departamento');
            }
            if (Yii::app()->user->rol == 'propietario') {
                $propietario_id = Propietario::model()->getId(Yii::app()->user->id);
                $dataProvider = new CActiveDataProvider('Departamento', array(
                    'criteria' => array(
                        'join' => 'JOIN propiedad p ON p.id = t.propiedad_id',
                        'condition' => 'p.propietario_id=:propietarioID',
                        'params' => array(':propietarioID' => $propietario_id),
                    )
                ));
            }
            if (Yii::app()->user->rol == 'cliente') {
                $cliente_id = Cliente::model()->getId(Yii::app()->user->id);
                $dataProvider = new CActiveDataProvider('Departamento', array(
                    'criteria' => array(
                        'join' => 'JOIN contrato c ON t.id = c.departamento_id',
                        'condition' => 'c.cliente_id=:clienteID',
                        'params' => array(':clienteID' => $cliente_id),
                    )
                ));
            }
		
            $this->render('index',array(
                    'dataProvider'=>$dataProvider,
            ));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Departamento('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Departamento']))
                    $model->attributes=$_GET['Departamento'];

                
                
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
		$model=Departamento::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='departamento-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	public function actionExportarXLS()
	{
		// generate a resultset
		$data = Departamento::model()->with('propiedad')->findAll();
		$this->toExcel($data,
			array('propiedad.nombre','numero','mt2','dormitorios','estacionamientos','renta'),
			'Departamentos',
			array()
		);
	}
}
