<?php
/* @var $this ContratoMuebleController */
/* @var $model ContratoMueble */

$this->breadcrumbs=array(
	'Contratos de Muebles'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Contratos de Muebles', 'url'=>array('admin')),
	array('label'=>'Crear Contrato Mueble', 'url'=>array('create')),
	array('label'=>'Actualizar Contrato Mueble', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Contrato Mueble', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>
    <?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'contrato_id',
	),
)); ?>
