<?php
/* @var $this IpcController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Ipcs',
);

$this->menu=array(
	array('label'=>'Crear Ipc', 'url'=>array('create')),
	array('label'=>'Administrar Ipc', 'url'=>array('admin')),
);
?>

<h1>Ipcs</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
