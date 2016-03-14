<?php
/* @var $this TipoPrestacionController */
/* @var $model TipoPrestacion */

$this->breadcrumbs = array(
    'Tipos Prestaciones' => array('admin'),
    'Actualizar',
);
$this->menu=array(
	array('label'=>'Crear Tipo de Prestación', 'url'=>array('create')),
	array('label'=>'Ver Tipo de Prestación', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Tipos de Prestaciones', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>