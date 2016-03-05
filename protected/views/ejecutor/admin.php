<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */

$this->breadcrumbs=array(
	'Maestros',
	
);

$this->menu=array(
	array('label'=>'Nuevo Maestro', 'url'=>array('create')),
);

?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ejecutor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rut',
		'nombre',
		'direccion',
		'telefono',
		'email',
		array('name'=>'especialidad_nm','value'=>'$data->especialidad->nombre'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
