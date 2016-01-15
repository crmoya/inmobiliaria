<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Tipo Contratos'=>array('admin'),
	$model->ida
);

$this->menu=array(
	array('label'=>'Crear Tipo de Contrato', 'url'=>array('create')),
	array('label'=>'Borrar Tipo de Contrato', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro de eliminar este item?')),
	array('label'=>'Administrar Tipo de Contrato', 'url'=>array('admin')),
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
