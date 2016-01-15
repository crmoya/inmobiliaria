<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */

$this->breadcrumbs=array(
	'Demanda Judicials'=>array('admin'),
	'Update',
);

$this->menu=array(
	array('label'=>'List DemandaJudicial', 'url'=>array('index')),
	array('label'=>'Create DemandaJudicial', 'url'=>array('create')),
	array('label'=>'View DemandaJudicial', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage DemandaJudicial', 'url'=>array('admin')),
);
?>

<h1>Update DemandaJudicial <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>