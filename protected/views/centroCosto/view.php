<?php
/* @var $this CentroCostoController */
/* @var $model CentroCosto */

$this->breadcrumbs=array(
	'Centro Costos'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Listar Centros de Costo', 'url'=>array('admin')),
	array('label'=>'Crear Centro de Costo', 'url'=>array('create')),
	array('label'=>'Actualizar Centro de Costo', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Centro de Costo', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
                array('name'=>'carga_a','value'=>Tools::backCargaA($model->carga_a)),
	),
)); 

?>
