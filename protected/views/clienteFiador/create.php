<?php
/* @var $this ClienteFiadorController */
/* @var $model ClienteFiador */

$this->breadcrumbs=array(
	'Cliente Fiadors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List ClienteFiador', 'url'=>array('index')),
	array('label'=>'Manage ClienteFiador', 'url'=>array('admin')),
);
?>

<h1>Create ClienteFiador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>