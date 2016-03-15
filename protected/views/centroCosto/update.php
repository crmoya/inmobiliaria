<?php
/* @var $this CentroCostoController */
/* @var $model CentroCosto */

$this->breadcrumbs=array(
	'Centros de Costos'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Centros de Costo', 'url'=>array('admin')),
	array('label'=>'Crear Centro de Costo', 'url'=>array('create')),
	array('label'=>'Ver Centro de Costo', 'url'=>array('view', 'id'=>$model->id)),
);
?>
<div class='span10'>
<?php $this->renderPartial('_form', array('model'=>$model)); ?>
</div>