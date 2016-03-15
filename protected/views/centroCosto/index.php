<?php
/* @var $this CentroCostoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Centro Costos',
);

$this->menu=array(
	array('label'=>'Create CentroCosto', 'url'=>array('create')),
	array('label'=>'Manage CentroCosto', 'url'=>array('admin')),
);
?>

<h1>Centro Costos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
