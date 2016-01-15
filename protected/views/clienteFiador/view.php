<?php
/* @var $this ClienteFiadorController */
/* @var $model ClienteFiador */

$this->breadcrumbs=array(
	'Cliente Fiadors'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ClienteFiador', 'url'=>array('index')),
	array('label'=>'Create ClienteFiador', 'url'=>array('create')),
	array('label'=>'Update ClienteFiador', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ClienteFiador', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ClienteFiador', 'url'=>array('admin')),
);
?>

<h1>View ClienteFiador #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'cliente_id',
		'fiador_id',
		'id',
	),
)); ?>
