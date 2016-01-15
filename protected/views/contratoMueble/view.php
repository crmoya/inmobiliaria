<?php
/* @var $this ContratoMuebleController */
/* @var $model ContratoMueble */

$this->breadcrumbs=array(
	'Contrato Muebles'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List ContratoMueble', 'url'=>array('index')),
	array('label'=>'Create ContratoMueble', 'url'=>array('create')),
	array('label'=>'Update ContratoMueble', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete ContratoMueble', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ContratoMueble', 'url'=>array('admin')),
);
?>

<h1>View ContratoMueble #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'contrato_id',
	),
)); ?>
