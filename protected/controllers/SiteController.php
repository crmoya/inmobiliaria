<?php

class SiteController extends Controller
{
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}
        
        public function actionAdmin(){
            $this->actionIndex();
        }
	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
            // renders the view file 'protected/views/site/index.php'
            // using the default layout 'protected/views/layouts/main.php'
            $this->render('index');
	}
        
        public function actionCambiarClave()
	{
		$form = new CambiarClaveForm();
		if (isset(Yii::app()->user->id))
		{
			if(isset($_POST['CambiarClaveForm']))
			{
				$form->attributes = $_POST['CambiarClaveForm'];
				if($form->validate())
				{
					$new_password = Usuario::model()->findByPk(Yii::app()->user->id);
                                        if(!CPasswordHelper::verifyPassword($form->clave, $new_password->clave))
					{
						$form->addError('clave', "clave incorrecta");
					}
					else
					{
						if($form->nueva == $form->repita){
							$new_password->clave = CPasswordHelper::hashPassword($form->nueva);								
							if($new_password->save())
							{
								Yii::app()->user->setFlash('profileMessage',
			 					"Clave cambiada correctamente.");
							}
							else
							{
								Yii::app()->user->setFlash('profileMessage',
			 					"No se pudo cambiar la clave, inténtelo de nuevo más tarde.");
							}	
							$this->refresh();
						}
						else{
							$form->addError('nueva', "claves nuevas no coinciden");
							$form->addError('repita', "claves nuevas no coinciden");
						}
						
					}
				}
			}
	 		$this->render('//site/cambiarClave',array('model'=>$form));
	 	}
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail(Yii::app()->params['adminEmail'],$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
        if(isset(Yii::app()->user->id))
        {
            $this->redirect(Yii::app()->request->baseUrl);
        }
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
               
        public function actionOlvidaste(){
            $model=new OlvidasteForm;
            if(isset($_POST['OlvidasteForm']))
            {
                $model->attributes=$_POST['OlvidasteForm'];
                $rand = rand(1000,10000);
                         
                $usuario = Usuario::model()->findByAttributes(array('user'=>$model->user));
                if($usuario != null){
                    if(mail($usuario->email,"Cambio de Clave",""
                        . "Estimado, ha solicitado el cambio de clave para el usuario '".$model->user."' para la aplicación inmobiliaria\n"
                        . "Su nueva clave es ".$rand
                        . "\nPor favor cámbiela cuanto antes desde Mi Cuenta / Cambiar mi Clave.")){
                        
                        $usuario->clave = sha1($rand);
                        $usuario->save();
                        Yii::app()->user->setFlash('profileMessage','Su nueva clave ha sido enviada a su correo.');
                        $this->refresh();
                    }
                }
            }
            $this->render('olvidaste',array('model'=>$model));
        }
        
        public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	public function accessRules()
	{
		return array(
		array('allow',
                    'actions'=>array('index','login','admin','error','download','olvidaste'),
                    'users'=>array('*'),
		),
                array('allow',
                    'actions'=>array('logout','cambiarClave'),
                    'users'=>array('@'),
		),
		array('deny',  // deny all users
                    'users'=>array('*'),
		),
		);
	}
}