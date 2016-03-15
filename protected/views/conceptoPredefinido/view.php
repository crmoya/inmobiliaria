<?php
/* @var $this ConceptoPredefinidoController */
/* @var $model ConceptoPredefinido */

$this->breadcrumbs=array(
	'Concepto Predefinidos'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Conceptos Predefinidos', 'url'=>array('admin')),
	array('label'=>'Crear Concepto Predefinido', 'url'=>array('create')),
	array('label'=>'Actualizar Concepto Predefinido', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Concepto Predefinido', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
