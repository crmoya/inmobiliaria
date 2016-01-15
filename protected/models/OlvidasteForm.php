<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class OlvidasteForm extends CFormModel
{
        public $user;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
            return array(
                array('user', 'required'),
            );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
            return array(
                'user'=>'Nombre de Usuario',
            );
	}

}
