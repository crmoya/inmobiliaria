<?php
/* @var $this IpcController */
/* @var $model Ipc */

$this->menu=array(
	array('label'=>'Administrar IPC', 'url'=>array('admin')),
);
?>

<h1>Crear Ipc</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>