<?php
/* @var $this ContratoMuebleController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Contrato Muebles',
);

$this->menu=array(
	array('label'=>'Create ContratoMueble', 'url'=>array('create')),
	array('label'=>'Manage ContratoMueble', 'url'=>array('admin')),
);
?>

<h1>Contrato Muebles</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
