<?php
/* @var $this ConceptoController */
/* @var $model Concepto */

$this->breadcrumbs=array(
	'Conceptos'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Administrar Conceptos', 'url'=>array('admin')),
);
?>

<h1>Crear Concepto</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>