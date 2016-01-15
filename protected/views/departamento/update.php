<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs=array(
	'Departamentos'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Crear Departamento', 'url'=>array('create')),
	array('label'=>'Ver Departamento', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Departamentos', 'url'=>array('admin')),
);
?>

<h1>Actualizar Departamento <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'propiedades'=>$propiedades)); ?>