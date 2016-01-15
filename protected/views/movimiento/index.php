<?php
/* @var $this MovimientoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Movimientos',
);

$this->menu=array(
	array('label'=>'Create Movimiento', 'url'=>array('create')),
	array('label'=>'Manage Movimiento', 'url'=>array('admin')),
);
?>

<h1>Movimientos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
