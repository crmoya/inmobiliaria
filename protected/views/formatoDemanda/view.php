<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Formatos Demandas'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Formato de Demanda', 'url'=>array('create')),
	array('label'=>'Borrar Formato de Demanda', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro de eliminar este item?')),
	array('label'=>'Administrar Formato de Demanda', 'url'=>array('admin')),
);
?>

<h1>TipoContrato #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>
