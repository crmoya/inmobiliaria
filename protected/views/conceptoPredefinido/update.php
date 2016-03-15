<?php
/* @var $this ConceptoPredefinidoController */
/* @var $model ConceptoPredefinido */

$this->breadcrumbs=array(
	'Conceptos Predefinidos'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Conceptos Predefinidos', 'url'=>array('admin')),
	array('label'=>'Crear Concepto Predefinido', 'url'=>array('create')),
	array('label'=>'Ver Concepto Predefinido', 'url'=>array('view', 'id'=>$model->id)),
);
?>
<div class="span10">
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>