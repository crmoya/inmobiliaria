<?php
/* @var $this FiadorController */
/* @var $model Fiador */

$this->breadcrumbs=array(
	'Fiadors'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Fiador', 'url'=>array('index')),
	array('label'=>'Create Fiador', 'url'=>array('create')),
	array('label'=>'View Fiador', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Fiador', 'url'=>array('admin')),
);
?>

<h1>Update Fiador <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>