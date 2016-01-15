<?php
/* @var $this CuentaCorrienteController */
/* @var $model CuentaCorriente */

$this->breadcrumbs=array(
	'Cuenta Corrientes'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Cuentas Corriente', 'url'=>array('admin')),
);
?>

<h1>Crear Cuenta Corriente</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
												'propModel'=>$propModel,
												'propietarios'=>$propietarios)); ?>