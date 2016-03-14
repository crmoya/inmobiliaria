<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */

$this->breadcrumbs=array(
	'Propiedades'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
);

$this->menu=array(
	array('label'=>'Crear Propiedad', 'url'=>array('create')),
	array('label'=>'Ver Propiedad', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Propiedades', 'url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'propietarios'=>$propietarios)); ?>