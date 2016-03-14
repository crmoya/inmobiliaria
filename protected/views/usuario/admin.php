<?php

$this->breadcrumbs=array(
	'Usuarios'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Crear Usuario', 'url'=>array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'usuario-grid',
	'dataProvider'=>$model->searchUsuarios(),
	'filter'=>$model,
	'columns'=>array(
		'user',
		'nombre',
                'apellido',
                'email',
		'rol',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
