<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Tipo Contratos'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Tipos de Contrato', 'url'=>array('admin')),
);
?>

<h1>Crear Tipo de Contrato</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>