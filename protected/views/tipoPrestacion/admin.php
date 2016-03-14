<?php
/* @var $this TipoPrestacionController */
/* @var $model TipoPrestacion */

$this->breadcrumbs=array(
	'Tipos de Prestaciones',
);

$this->menu=array(
	array('label'=>'Crear Tipo de Prestación', 'url'=>array('create')),
);?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tipo-prestacion-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
