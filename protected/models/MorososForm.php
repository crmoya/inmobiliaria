<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class MorososForm extends CFormModel
{
    public $propiedad_id;
    public $departamento_id;
    public $dias;
            
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
            return array(
                array('propiedad_id,departamento_id,dias', 'length', 'max'=>10),
            );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
            return array(
                'propiedad_id'=>'Propiedad:',
                'departamento_id'=>'Departamento:',
                'dias'=>'Días:',
            );
	}

}
