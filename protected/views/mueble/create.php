<?php
/* @var $this MuebleController */
/* @var $model Mueble */

$this->menu=array(
	array('label'=>'Administrar Muebles', 'url'=>array('admin')),
);
?>

<h1>Crear Mueble</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>