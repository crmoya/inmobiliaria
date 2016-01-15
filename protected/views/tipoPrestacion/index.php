<?php
/* @var $this TipoPrestacionController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tipo Prestaciones',
);

$this->menu=array(
	array('label'=>'Crear Tipo de Prestacion', 'url'=>array('create')),
	array('label'=>'Administrar Tipos de Prestacion', 'url'=>array('admin')),
);
?>

<h1>Tipos de Prestacion</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
