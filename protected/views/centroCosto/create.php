<?php
/* @var $this CentroCostoController */
/* @var $model CentroCosto */

$this->breadcrumbs=array(
	'Centros de Costos'=>array('admin'),
	'Nuevo Centro de Costo',
);

$this->menu=array(
	array('label'=>'Listar Centro de Costo', 'url'=>array('admin')),
);
?>
<div class='span10'>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>