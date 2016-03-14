<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */

$this->breadcrumbs=array(
	'Demandas Judiciales'=>array('admin'),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Demandas', 'url'=>array('admin')),
	array('label'=>'Crear Demanda', 'url'=>array('create')),
	array('label'=>'Ver Demanda', 'url'=>array('view', 'id'=>$model->id)),
);
?>
<div class="span10">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>