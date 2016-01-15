<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->menu=array(
	array('label'=>'Administrar Cliente', 'url'=>array('admin')),
);
?>

<h1>Crear Cliente</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>