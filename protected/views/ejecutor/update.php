<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */

$this->breadcrumbs=array(
	'Maestros'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Ejecutor', 'url'=>array('create')),
	array('label'=>'Ver Ejecutor', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Ejecutores', 'url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>