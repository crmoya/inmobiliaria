<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class IngresosForm extends CFormModel
{
    public $mesD;
    public $mesH;
    public $agnoD;
    public $agnoH;
    public $propiedad_id;
    public $abonosYCargos;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
                    array('mesD,mesH,agnoD,agnoH,propiedad_id', 'required'),
                    array('propiedad_id', 'numerical', 'integerOnly'=>true),
                    array('abonosYCargos', 'length', 'max'=>2),
		);
	}

	/**
	 * Declares customized attribute labels.
	 * If not declared here, an attribute would have a label that is
	 * the same as its name with the first letter in upper case.
	 */
	public function attributeLabels()
	{
		return array(
                    'mesD'=>'Mes Inicio:',
                    'mesH'=>'Mes Fin:',
                    'agnoD'=>'Año Inicio:',
                    'agnoH'=>'Año Fin:', 
                    'propiedad_id'=>'Propiedad:',
                    'abonosYCargos'=>'ABONOS Y CARGOS',
		);
	}
}