<?php
/* @var $this ContratoMuebleController */
/* @var $model ContratoMueble */

$this->breadcrumbs=array(
	'Contrato Muebles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List ContratoMueble', 'url'=>array('index')),
	array('label'=>'Create ContratoMueble', 'url'=>array('create')),
	array('label'=>'View ContratoMueble', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage ContratoMueble', 'url'=>array('admin')),
);
?>

<h1>Update ContratoMueble <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>