<?php
/* @var $this EspecialidadController */
/* @var $model Especialidad */

$this->breadcrumbs=array(
	'Especialidades'=>array('admin'),
	'Editar',
);

$this->menu=array(
	array('label'=>'Crear Especialidad', 'url'=>array('create')),
	array('label'=>'Ver Especialidad', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Listar Especialidades', 'url'=>array('admin')),
);
?>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>