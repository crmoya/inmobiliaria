<?php
/* @var $this TipoPrestacionController */
/* @var $model TipoPrestacion */

$this->menu=array(
	array('label'=>'Crear Tipo de Prestación', 'url'=>array('create')),
	array('label'=>'Ver Tipo de Prestación', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Tipos de Prestaciones', 'url'=>array('admin')),
);
?>

<h1>Editar Tipo de Prestación <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>