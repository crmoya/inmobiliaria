<?php
/* @var $this ClienteController */
/* @var $model Cliente */


$this->menu=array(
	array('label'=>'Crear Cliente', 'url'=>array('create')),
	array('label'=>'Editar Cliente', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Cliente', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro quiere eliminar este Cliente?')),
	array('label'=>'Administrar Clientes', 'url'=>array('admin')),
);
?>

<h1>Ver Cliente #<?php echo $model->id; ?></h1>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
                'rut',
                'usuario.nombre',
                'usuario.apellido',
                'usuario.email',
                'direccion_alternativa',
		'telefono',
		'ocupacion',
		'renta',
                'clienteFiadors.fiador.rut',
                'clienteFiadors.fiador.nombre',
                'clienteFiadors.fiador.apellido',
                'clienteFiadors.fiador.email',
                'clienteFiadors.fiador.telefono',
                'clienteFiadors.fiador.direccion',
	),
)); ?>
