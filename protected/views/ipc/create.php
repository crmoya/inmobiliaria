<?php
/* @var $this IpcController */
/* @var $model Ipc */

$this->menu=array(
	array('label'=>'Administrar IPC', 'url'=>array('admin')),
);

$this->breadcrumbs = array(
    'IPC' => array('admin'),
    'Nuevo IPC',
);
?>
<div class="span10">

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>