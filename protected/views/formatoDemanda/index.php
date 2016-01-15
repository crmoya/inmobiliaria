<?php
/* @var $this TipoContratoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Formatos de Demanda',
);

$this->menu=array(
	array('label'=>'Crear Formato de Demanda', 'url'=>array('create')),
	array('label'=>'Administrar Formato de Demanda', 'url'=>array('admin')),
);
?>

<h1>Formatos de Demanda</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
