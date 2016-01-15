<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */

$this->breadcrumbs=array(
	'Ejecutores'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Ejecutores', 'url'=>array('admin')),
);
?>

<h1>Crear Ejecutor</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>