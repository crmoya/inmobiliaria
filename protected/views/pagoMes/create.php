<?php
/* @var $this PagoMesController */
/* @var $model PagoMes */

$this->breadcrumbs=array(
	'Pago Mes'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List PagoMes', 'url'=>array('index')),
	array('label'=>'Manage PagoMes', 'url'=>array('admin')),
);
?>

<h1>Create PagoMes</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>