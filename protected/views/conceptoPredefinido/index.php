<?php
/* @var $this ConceptoPredefinidoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Concepto Predefinidos',
);

$this->menu=array(
	array('label'=>'Create ConceptoPredefinido', 'url'=>array('create')),
	array('label'=>'Manage ConceptoPredefinido', 'url'=>array('admin')),
);
?>

<h1>Concepto Predefinidos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
