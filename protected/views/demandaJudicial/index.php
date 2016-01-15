<?php
/* @var $this DemandaJudicialController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Demanda Judicials',
);

$this->menu=array(
	array('label'=>'Create DemandaJudicial', 'url'=>array('create')),
	array('label'=>'Manage DemandaJudicial', 'url'=>array('admin')),
);
?>

<h1>Demanda Judicials</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
