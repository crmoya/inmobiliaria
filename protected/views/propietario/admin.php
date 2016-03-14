<?php
/* @var $this PropietarioController */
/* @var $model Propietario */

$this->breadcrumbs=array(
	'Propietarios',
);

$this->menu=array(
	array('label'=>'Crear Propietario', 'url'=>array('create')),
);
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'propietario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                'rut',
                array('name'=>'nombre', 'value'=>'$data->usuario->nombre'),
                array('name'=>'apellido', 'value'=>'$data->usuario->apellido'),
                array('name'=>'email', 'value'=>'$data->usuario->email'),
                'direccion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
