<?php
/* @var $this ConceptoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Conceptos',
);

$this->menu=array(
	array('label'=>'Crear Concepto', 'url'=>array('create')),
	array('label'=>'Administrar Conceptos', 'url'=>array('admin')),
);
?>

<h1>Conceptos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
