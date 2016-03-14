<?php
/* @var $this MuebleController */
/* @var $model Mueble */

$this->menu=array(
	array('label'=>'Administrar Muebles', 'url'=>array('admin')),
);


$this->breadcrumbs=array(
	'Muebles'=>array('admin'),
	'Administrar',
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
		array('name'=>'fecha_compra', 'value'=>Tools::backFecha($model->fecha_compra)),
		array('name'=>'proveedor_nom', 'value'=>$model->proveedor->nombre),
	),
)); ?>
