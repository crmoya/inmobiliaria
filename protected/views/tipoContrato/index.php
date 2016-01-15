<?php
/* @var $this TipoContratoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Tipo Contratos',
);

$this->menu=array(
	array('label'=>'Crear Tipos de Contrato', 'url'=>array('create')),
	array('label'=>'Administrar Tipos de Contrato', 'url'=>array('admin')),
);
?>

<h1>Tipos de Contrato</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
