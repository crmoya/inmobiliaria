<?php
/* @var $this PagoMesController */
/* @var $model PagoMes */

$this->breadcrumbs=array(
	'Pago Mes'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List PagoMes', 'url'=>array('index')),
	array('label'=>'Create PagoMes', 'url'=>array('create')),
	array('label'=>'Update PagoMes', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete PagoMes', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage PagoMes', 'url'=>array('admin')),
);
?>

<h1>View PagoMes #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'contrato_id',
		'monto_renta',
		'gasto_comun',
		'gasto_variable',
		'monto_mueble',
		'fecha',
	),
)); ?>
