<?php
/* @var $this IpcController */
/* @var $model Ipc */


$this->breadcrumbs = array(
    'IPC' => array('admin'),
    $model->id,
);

$this->menu=array(
	array('label'=>'Crear IPC', 'url'=>array('create')),
	array('label'=>'Editar IPC', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar IPC', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar IPC', 'url'=>array('admin')),
);
?>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            'porcentaje',
            array('name'=>'mes','value'=>Tools::fixMes($model->mes)),
            'agno',
	),
)); ?>
