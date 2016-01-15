<?php
/* @var $this FormatoCartaController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Formato Cartas',
);

$this->menu=array(
	array('label'=>'Crear Formato Carta', 'url'=>array('create')),
	array('label'=>'Administrar Formato Carta', 'url'=>array('admin')),
);
?>

<h1>Formato Carta</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
