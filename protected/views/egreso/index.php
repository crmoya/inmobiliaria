<?php
/* @var $this EgresoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Egresos',
);

$this->menu=array(
	array('label'=>'Create Egreso', 'url'=>array('create')),
	array('label'=>'Manage Egreso', 'url'=>array('admin')),
);
?>

<h1>Egresos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
