<?php
/* @var $this EgresoController */
/* @var $model Egreso */

$this->breadcrumbs=array(
	'Egresos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Egreso', 'url'=>array('admin')),
	array('label'=>'Crear Egreso', 'url'=>array('create')),
	array('label'=>'Ver Egreso', 'url'=>array('view', 'id'=>$model->id)),
);
?>
<div class="span12">
<?php $this->renderPartial('_form', array('model'=>$model,'conceptos'=>$conceptos,'departamentos'=>$departamentos)); ?>
</div>