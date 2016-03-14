<?php
/* @var $this TipoPrestacionController */
/* @var $model TipoPrestacion */

$this->breadcrumbs = array(
    'Tipos Prestaciones' => array('admin'),
    $model->id,
);

$this->menu=array(
        array('label'=>'Crear Tipo de Prestación', 'url'=>array('create')),
	array('label'=>'Editar Tipo de Prestación', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Tipo de Prestación', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar Tipos de Prestaciones', 'url'=>array('admin')),
);
?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'nombre',
	),
)); ?>
