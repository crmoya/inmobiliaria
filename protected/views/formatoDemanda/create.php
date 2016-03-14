<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Formatos de Demanda'=>array('admin'),
	'Nuevo Formato',
);

$this->menu=array(
	array('label'=>'Administrar Formatos de Demanda', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>