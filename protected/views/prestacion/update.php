<?php
/* @var $this PrestacionController */
/* @var $model Prestacion */

$this->menu=array(
	array('label'=>'Crear Prestación', 'url'=>array('create')),
	array('label'=>'Ver Prestación', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Prestación', 'url'=>array('admin')),
);
?>

<h1>Editar Prestación <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model,'departamentos'=>$departamentos)); ?>