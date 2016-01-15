<?php
$this->menu=array(
	array('label'=>'Crear Usuario', 'url'=>array('create')),
	array('label'=>'Editar Usuario', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Usuario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro desea borrar este registro?')),
	array('label'=>'Administrar Usuarios', 'url'=>array('admin')),
);
?>
<h1>Ver Usuario #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'user',
                'nombre',
                'apellido',
                'email',
		'rol',
	),
)); ?>
