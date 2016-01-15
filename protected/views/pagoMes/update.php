<?php
/* @var $this PagoMesController */
/* @var $model PagoMes */

$this->breadcrumbs=array(
	'Pago Mes'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List PagoMes', 'url'=>array('index')),
	array('label'=>'Create PagoMes', 'url'=>array('create')),
	array('label'=>'View PagoMes', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage PagoMes', 'url'=>array('admin')),
);
?>

<h1>Update PagoMes <?php echo $model->id; ?></h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>