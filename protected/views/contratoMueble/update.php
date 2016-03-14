<?php
/* @var $this ContratoMuebleController */
/* @var $model ContratoMueble */

$this->breadcrumbs=array(
	'Contrato Muebles'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Listar Contratos Muebles', 'url'=>array('admin')),
	array('label'=>'Crear Contrato Mueble', 'url'=>array('create')),
	array('label'=>'Ver Contrato Mueble', 'url'=>array('view', 'id'=>$model->id)),
);
?>
<div class="span10">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>