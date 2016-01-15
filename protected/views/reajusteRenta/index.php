<?php
/* @var $this ReajusteRentaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Reajuste Rentas',
);

$this->menu=array(
	array('label'=>'Create ReajusteRenta', 'url'=>array('create')),
	array('label'=>'Manage ReajusteRenta', 'url'=>array('admin')),
);
?>

<h1>Reajuste Rentas</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
