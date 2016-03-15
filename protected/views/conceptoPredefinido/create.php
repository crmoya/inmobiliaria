<?php
/* @var $this ConceptoPredefinidoController */
/* @var $model ConceptoPredefinido */

$this->breadcrumbs=array(
	'Conceptos Predefinidos'=>array('admin'),
	'Nuevo concepto predefinido',
);

$this->menu=array(
	array('label'=>'Listar Conceptos Predefinidos', 'url'=>array('admin')),
);
?>
<div class="span10">
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>