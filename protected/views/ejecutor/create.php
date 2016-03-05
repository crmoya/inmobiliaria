<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */

$this->breadcrumbs=array(
	'Maestros'=>array('admin'),
	'Nuevo Maestro',
);

?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>