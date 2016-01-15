<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->menu=array(
	array('label'=>'Crear Cliente', 'url'=>array('create')),
	array('label'=>'Ver Cliente', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Clientes', 'url'=>array('admin')),
);
?>

<h1>Editar Cliente <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>