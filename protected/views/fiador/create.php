<?php
/* @var $this FiadorController */
/* @var $model Fiador */

$this->breadcrumbs=array(
	'Fiadors'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Fiador', 'url'=>array('index')),
	array('label'=>'Manage Fiador', 'url'=>array('admin')),
);
?>

<h1>Create Fiador</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>