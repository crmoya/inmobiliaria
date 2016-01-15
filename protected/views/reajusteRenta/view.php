<?php
/* @var $this ReajusteRentaController */
/* @var $model ReajusteRenta */

$this->breadcrumbs=array(
	'Reajustes de Rentas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Reajuste de Renta', 'url'=>array('create')),
	array('label'=>'Editar Reajuste de Renta', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Reajuste de Renta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro desea eliminar este Reajuste de Renta?')),
	array('label'=>'Administrar Reajustes de Renta', 'url'=>array('admin')),
);
?>

<h1>Ver Reajuste de Renta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		array('name'=>'fecha_desde', 'value'=>Tools::backFecha($model->fecha_desde)),
		'porcentaje',
	),
)); ?>
