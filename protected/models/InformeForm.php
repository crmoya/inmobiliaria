<?php

/**
 * ContactForm class.
 * ContactForm is the data structure for keeping
 * contact form data. It is used by the 'contact' action of 'SiteController'.
 */
class InformeForm extends CFormModel
{
	public $fechaDesde;
	public $fechaHasta;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			// name, email, subject and body are required
			array('fechaDesde,fechaHasta', 'required'),
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
			'fechaDesde'=>'Fecha Desde',
                    'fechaHasta'=>'Fecha Hasta',
		);
	}
}