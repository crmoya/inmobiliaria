<?php

class DebePagarController extends Controller
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
                    'actions' => array('view'),
                    'roles' => array('superusuario','propietario'),
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
            $contrato = Contrato::model()->findByPk($id);
            
            if(Yii::app()->user->rol == 'propietario'){
                if(!$contrato->estaAsociadoAPropietario(Yii::app()->user->id)){
                    throw new CHttpException(403, 'Usted no se encuentra autorizado para realizar esta acción.');
                }   
            }
            
            $model=new DebePagar('search');
            $model->unsetAttributes();  // clear any default values
            if(isset($_GET['DebePagar']))
                    $model->attributes=$_GET['DebePagar'];

            $this->render('view',array(
                    'model'=>$model,
                    'contrato'=>$contrato,
            ));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Ejecutor::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='ejecutor-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
