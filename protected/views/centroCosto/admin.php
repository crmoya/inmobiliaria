<?php
/* @var $this CentroCostoController */
/* @var $model CentroCosto */

$this->breadcrumbs=array(
	'Centros de Costos'
);

$this->menu=array(
	array('label'=>'Crear Centro de Costo', 'url'=>array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'centro-costo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
