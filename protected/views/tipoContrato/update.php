<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Tipo Contratos'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Tipo de Contrato', 'url'=>array('create')),
	array('label'=>'Ver Tipo de Contrato', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Tipos de Contrato', 'url'=>array('admin')),
);
?>

<h1>Actualizar Tipo de Contrato <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>