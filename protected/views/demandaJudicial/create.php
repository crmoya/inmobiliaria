<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */

$this->breadcrumbs=array(
	'Demandas Judiciales'=>array('admin'),
	'Nueva demanada',
);

$this->menu=array(
	array('label'=>'Administrar Demandas Judiciales', 'url'=>array('admin')),
);
?>

<div class="span10">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>