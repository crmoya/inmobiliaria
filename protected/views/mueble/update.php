<?php
/* @var $this MuebleController */
/* @var $model Mueble */

$this->menu=array(
	array('label'=>'Crear Mueble', 'url'=>array('create')),
	array('label'=>'Ver Mueble', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Muebles', 'url'=>array('admin')),
);
?>

<h1>Editar Mueble <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>