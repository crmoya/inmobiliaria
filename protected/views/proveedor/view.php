<?php
/* @var $this ProveedorController */
/* @var $model Proveedor */

$this->breadcrumbs=array(
	'Proveedores'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Proveedores', 'url'=>array('create')),
	array('label'=>'Actualizar Proveedor', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Borrar Proveedor', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro desea eliminar este proveedor?')),
	array('label'=>'Administrar Proveedores', 'url'=>array('admin')),
);
?>

<h1>Proveedor #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'rut',
                'nombre',
		'direccion',
		'contacto',
		'email',
		'telefono',
	),
)); ?>
