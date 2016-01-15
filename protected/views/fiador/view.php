<?php
/* @var $this FiadorController */
/* @var $model Fiador */

$this->breadcrumbs=array(
	'Fiadors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Fiador', 'url'=>array('index')),
	array('label'=>'Create Fiador', 'url'=>array('create')),
	array('label'=>'Update Fiador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Fiador', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Fiador', 'url'=>array('admin')),
);
?>

<h1>View Fiador #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'rut',
		'ap_paterno',
		'ap_materno',
		'nombre',
		'email',
		'telefono',
		'direccion',
	),
)); ?>
