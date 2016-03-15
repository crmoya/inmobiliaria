<?php
/* @var $this EgresoController */
/* @var $model Egreso */

$this->breadcrumbs=array(
	'Egresos'=>array('admin'),
	'Egreso #'.$model->id,
);

$this->menu=array(
	array('label'=>'Listar Egresos', 'url'=>array('admin')),
	array('label'=>'Crear Egreso', 'url'=>array('create')),
	array('label'=>'Actualizar Egreso', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Egreso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'fecha','value'=>Tools::backFecha($model->fecha)),
		'monto',
		'concepto',
		'respaldo',
		'cta_contable',
		'nro_cheque',
		'centro_costo_id',
		'proveedor',
		'nro_documento',
	),
)); ?>
