<?php
/* @var $this PropietarioController */
/* @var $model Propietario */

$this->menu=array(
	array('label'=>'Administrar Propietarios', 'url'=>array('admin')),
);

$this->breadcrumbs=array(
	'Propietarios'=>array('admin'),
	'Nuevo Propietario',
);

?>
<div class="span12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>