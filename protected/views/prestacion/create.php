<?php
/* @var $this PrestacionController */
/* @var $model Prestacion */

$this->menu=array(
	array('label'=>'Administrar Prestaciones', 'url'=>array('admin')),
);
?>

<h1>Crear Prestación</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'departamentos'=>$departamentos)); ?>
