<?php
/* @var $this EspecialidadController */
/* @var $model Especialidad */

$this->breadcrumbs=array(
	'Especialidades'=>array('admin'),
	$model->nombre,
);

$this->menu=array(
	array('label'=>'Crear Especialidad', 'url'=>array('create')),
	array('label'=>'Editar Especialidad', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Especialidad', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Listar Especialidades', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
