<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */

$this->breadcrumbs=array(
	'Demanda Judicials'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Demanda Judicial', 'url'=>array('create')),
	array('label'=>'Eliminar Demanda Judicial', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro desea eliminar este registro?')),
	array('label'=>'Administrar Demandas Judiciales', 'url'=>array('admin')),
);
?>

<h1>View DemandaJudicial #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rol',
		'causa',
		'contrato_id',
	),
)); ?>
