<?php
/* @var $this ConceptoController */
/* @var $model Concepto */

$this->breadcrumbs=array(
	'Conceptos'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'Listar Conceptos', 'url'=>array('index')),
	array('label'=>'Crear Concepto', 'url'=>array('create')),
	array('label'=>'Ver Concepto', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Conceptos', 'url'=>array('admin')),
);
?>

<h1>Actualizar Concepto <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>