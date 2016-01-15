<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */

$this->breadcrumbs=array(
	'Propiedades'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Propiedades', 'url'=>array('admin')),
);
?>

<h1>Crear Propiedad</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'propietarios'=>$propietarios)); ?>