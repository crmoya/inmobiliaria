<?php
/* @var $this PropietarioController */
/* @var $model Propietario */


$this->breadcrumbs=array(
	'Propietarios'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Propietario', 'url'=>array('create')),
	array('label'=>'Ver Propietario', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Propietarios', 'url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>