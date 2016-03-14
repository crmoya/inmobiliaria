<?php
/* @var $this MuebleController */
/* @var $model Mueble */

$this->menu=array(
	array('label'=>'Crear Mueble', 'url'=>array('create')),
	array('label'=>'Administrar Muebles', 'url'=>array('admin')),
);

$this->breadcrumbs=array(
	'Muebles'=>array('admin'),
	'Administrar',
);
?>
<div class="span10">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>