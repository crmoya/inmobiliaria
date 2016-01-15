<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Formatos de Demanda'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Formatos de Demanda', 'url'=>array('admin')),
);
?>

<h1>Crear Formato de Demanda</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>