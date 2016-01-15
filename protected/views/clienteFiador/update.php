<?php
/* @var $this ClienteFiadorController */
/* @var $model ClienteFiador */

$this->breadcrumbs=array(
	'Cliente Fiadors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ClienteFiador', 'url'=>array('index')),
	array('label'=>'Create ClienteFiador', 'url'=>array('create')),
	array('label'=>'View ClienteFiador', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ClienteFiador', 'url'=>array('admin')),
);
?>

<h1>Update ClienteFiador <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>