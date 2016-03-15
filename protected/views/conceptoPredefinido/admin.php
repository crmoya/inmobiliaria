<?php
/* @var $this ConceptoPredefinidoController */
/* @var $model ConceptoPredefinido */

$this->breadcrumbs=array(
	'Conceptos Predefinidos'
);

$this->menu=array(
	array('label'=>'Nuevo Concepto Predefinido', 'url'=>array('create')),
);?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'concepto-predefinido-grid',
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
