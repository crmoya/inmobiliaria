<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class EstadoCuentaForm extends CFormModel
{
    public $mesD;
    public $mesH;
    public $agnoD;
    public $agnoH;
    public $conDetalle;
    public $desdeSaldo0;
    public $contratoId;
    public $desdeInicio;
            
	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
            return array(
                array('mesD,mesH,agnoD,agnoH', 'required'),
                array('desdeSaldo0,desdeInicio,conDetalle,contratoId', 'length', 'max'=>10),
                
            );
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
            return array(
                'mesD'=>'Mes:',
                'mesH'=>'Mes:',
                'agnoD'=>'Año:',
                'agnoH'=>'Año:',   
                'desdeSaldo0'=>'Desde Saldo 0:',
                'desdeInicio'=>'Desde Inicio del Contrato:',
            );
	}

}
