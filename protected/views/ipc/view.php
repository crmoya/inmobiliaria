<?php
/* @var $this IpcController */
/* @var $model Ipc */

$this->menu=array(
	array('label'=>'Crear IPC', 'url'=>array('create')),
	array('label'=>'Editar IPC', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar IPC', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Administrar IPC', 'url'=>array('admin')),
);
?>

<h1>Ver Ipc #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            'porcentaje',
            array('name'=>'mes','value'=>Tools::fixMes($model->mes)),
            'agno',
	),
)); ?>
