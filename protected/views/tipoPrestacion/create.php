<?php
/* @var $this TipoPrestacionController */
/* @var $model TipoPrestacion */

$this->menu=array(
	array('label'=>'Administrar Tipo de Prestación', 'url'=>array('admin')),
);
?>

<h1>Crear Tipo de Prestación</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>