<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */

$this->breadcrumbs=array(
	'Demandas Judiciales'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Administrar Demandas Judiciales', 'url'=>array('admin')),
);
?>

<h1>Crear Demanda Judicial</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>