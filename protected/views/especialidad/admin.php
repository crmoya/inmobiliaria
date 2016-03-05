<?php
/* @var $this EspecialidadController */
/* @var $model Especialidad */

$this->breadcrumbs=array(
	'Especialidades'
);

$this->menu=array(
	array('label'=>'Nueva Especialidad', 'url'=>array('create')),
);
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'especialidad-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
