<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs=array(
	'Departamentos'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Administrar Departamentos', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'propiedades'=>$propiedades)); ?>