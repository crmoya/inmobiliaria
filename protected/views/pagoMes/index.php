<?php
/* @var $this PagoMesController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Pago Mes',
);

$this->menu=array(
	array('label'=>'Create PagoMes', 'url'=>array('create')),
	array('label'=>'Manage PagoMes', 'url'=>array('admin')),
);
?>

<h1>Pago Mes</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
