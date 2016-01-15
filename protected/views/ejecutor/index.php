<?php
/* @var $this EjecutorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ejecutores',
);

$this->menu=array(
	array('label'=>'Crear Ejecutores', 'url'=>array('create')),
	array('label'=>'Administrar Ejecutores', 'url'=>array('admin')),
);
?>

<h1>Ejecutores</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
