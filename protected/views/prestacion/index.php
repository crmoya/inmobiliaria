<?php
/* @var $this PrestacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Prestaciones',
);

$this->menu=array(
	array('label'=>'Crear Prestacion', 'url'=>array('create')),
	array('label'=>'Administrar Prestaciones', 'url'=>array('admin')),
);
?>

<h1>Prestaciones</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
