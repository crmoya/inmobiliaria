<?php
/* @var $this PrestacionController */
/* @var $model Prestacion */


$this->breadcrumbs=array(
    'Prestaciones'=>array('admin'),
    'Editar Prestación #'.$model->id,
);


$this->menu=array(
	array('label'=>'Crear Prestación', 'url'=>array('create')),
	array('label'=>'Ver Prestación', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Prestación', 'url'=>array('admin')),
);
?>


<?php echo $this->renderPartial('_form', array('model'=>$model,'departamentos'=>$departamentos)); ?>