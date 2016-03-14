<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Formatos de Contratos'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Formatos de Contrato', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>