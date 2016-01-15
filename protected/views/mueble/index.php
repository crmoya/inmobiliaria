<?php
/* @var $this MuebleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Muebles',
);

$this->menu=array(
	array('label'=>'Crear Mueble', 'url'=>array('create')),
	array('label'=>'Administrar Muebles', 'url'=>array('admin')),
);
?>

<h1>Muebles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
