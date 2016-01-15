<?php
/* @var $this CuentaCorrienteController */
/* @var $model CuentaCorriente */

$this->breadcrumbs=array(
	'Cuenta Corrientes'=>array('admin'),
	$model->id,
);

?>

<h1>Cuenta Corriente #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array(
			'label'=>'Nombre Cuenta',
			'value'=>$model->nombre
		),
		'saldo_inicial',
                array(
			'label'=>'Rut Cliente',
			'value'=>$model->contrato->cliente->rut,
		),
                array(
			'label'=>'Nombre Cliente',
			'value'=>$model->contrato->cliente->usuario->nombre." ".$model->contrato->cliente->usuario->apellido,
		),
	),
)); ?>
