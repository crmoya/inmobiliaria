<?php
/* @var $this CuentaCorrienteController */
/* @var $model CuentaCorriente */

$this->breadcrumbs=array(
	'Cuentas Corriente'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Cuenta Corriente', 'url'=>array('create')),
	array('label'=>'Ver Cuenta Corriente', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Actualizar Cuentas Corriente', 'url'=>array('admin')),
);
?>

<h1>Actualizar Cuenta Corriente <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,
												'propModel'=>$propModel,
												'propietarios'=>$propietarios)); ?>