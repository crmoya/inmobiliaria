<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Formatos Demandas'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Formato de Demanda', 'url'=>array('create')),
	array('label'=>'Ver Formato de Demanda', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Formato de Demanda', 'url'=>array('admin')),
);
?>

<h1>Actualizar Formato de Demanda <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>