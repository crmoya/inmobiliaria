<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */

$this->breadcrumbs=array(
	'Movimientos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Movimiento', 'url'=>array('index')),
	array('label'=>'Create Movimiento', 'url'=>array('create')),
	array('label'=>'Update Movimiento', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Movimiento', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Movimiento', 'url'=>array('admin')),
);
?>

<h1>View Movimiento #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'fecha',
		'tipo',
		'monto',
		'detalle',
		'cuenta_corriente_id',
	),
)); ?>
