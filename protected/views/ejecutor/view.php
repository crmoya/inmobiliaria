<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */

$this->breadcrumbs=array(
	'Maestros'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Maestro', 'url'=>array('create')),
	array('label'=>'Editar Maestro', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Maestro', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro desea eliminar este registro?')),
	array('label'=>'Listar Maestros', 'url'=>array('admin')),
);
?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rut',
		'nombre',
		'direccion',
		'telefono',
		'email',
		array('name'=>'especialidad_nm','value'=>$model->especialidad->nombre),
	),
)); ?>
