<?php
/* @var $this ContratoMuebleController */
/* @var $model ContratoMueble */

$this->breadcrumbs=array(
	'Contrato Muebles'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Contrato Mueble', 'url'=>array('admin')),
);
?>

<h1>Crear Contrato de Bienes Muebles</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>