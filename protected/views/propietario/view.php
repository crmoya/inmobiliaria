<?php
/* @var $this PropietarioController */
/* @var $model Propietario */

$this->menu=array(
	array('label'=>'Crear Propietario', 'url'=>array('create')),
	array('label'=>'Editar Propietario', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Propietario', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro desea eliminar este propietario?')),
	array('label'=>'Administrar Propietarios', 'url'=>array('admin')),
);


$this->breadcrumbs=array(
	'Propietarios'=>array('admin'),
	'Propietario #'.$model->id,
);
?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            'rut',
            'usuario.email',
            'usuario.nombre',
            'usuario.apellido',
            'usuario.email',
            'direccion',                
	),
)); ?>
