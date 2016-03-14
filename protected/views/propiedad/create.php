<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */

$this->breadcrumbs=array(
	'Propiedades'=>array('admin'),
	'Nueva Propiedad',
);

$this->menu=array(
	array('label'=>'Administrar Propiedades', 'url'=>array('admin')),
);
?>

<div class="span12">

<?php echo $this->renderPartial('_form', array('model'=>$model,'propietarios'=>$propietarios)); ?>
</div>