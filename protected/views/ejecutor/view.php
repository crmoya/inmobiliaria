<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */

$this->breadcrumbs=array(
	'Ejecutores'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Ejecutor', 'url'=>array('create')),
	array('label'=>'Actualizar Ejecutor', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Ejecutor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Ejecutores', 'url'=>array('admin')),
);
?>

<h1>Ejecutor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'rut',
		'nombre',
		'direccion',
		'telefono',
		'email',
		'especialidad',
	),
)); ?>
