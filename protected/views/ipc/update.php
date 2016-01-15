<?php
/* @var $this IpcController */
/* @var $model Ipc */

$this->menu=array(
	array('label'=>'Crear IPC', 'url'=>array('create')),
	array('label'=>'Ver IPC', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar IPC', 'url'=>array('admin')),
);
?>

<h1>Editar Ipc <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>