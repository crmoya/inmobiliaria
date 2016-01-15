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

<h1>Crear Departamento</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'propiedades'=>$propiedades)); ?>