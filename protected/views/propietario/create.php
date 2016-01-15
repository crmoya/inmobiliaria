<?php
/* @var $this PropietarioController */
/* @var $model Propietario */

$this->menu=array(
	array('label'=>'Administrar Propietarios', 'url'=>array('admin')),
);
?>

<h1>Crear Propietario</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>