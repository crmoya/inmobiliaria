<?php
/* @var $this ConceptoController */
/* @var $model Concepto */

$this->breadcrumbs=array(
	'Conceptos'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Conceptos', 'url'=>array('index')),
	array('label'=>'Crear Concepto', 'url'=>array('create')),
	array('label'=>'Actualizar Concepto', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Concepto', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro de borrar este elemento?')),
	array('label'=>'Administrar Conceptos', 'url'=>array('admin')),
);
?>

<h1>Concepto #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
