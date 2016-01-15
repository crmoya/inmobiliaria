<?php
/* @var $this ClienteFiadorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cliente Fiadors',
);

$this->menu=array(
	array('label'=>'Create ClienteFiador', 'url'=>array('create')),
	array('label'=>'Manage ClienteFiador', 'url'=>array('admin')),
);
?>

<h1>Cliente Fiadors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
