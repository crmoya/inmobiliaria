<?php
/* @var $this FiadorController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Fiadors',
);

$this->menu=array(
	array('label'=>'Create Fiador', 'url'=>array('create')),
	array('label'=>'Manage Fiador', 'url'=>array('admin')),
);
?>

<h1>Fiadors</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
