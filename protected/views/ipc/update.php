<?php
/* @var $this IpcController */
/* @var $model Ipc */

$this->breadcrumbs = array(
    'IPC' => array('admin'),
    $model->id,
);
$this->menu=array(
	array('label'=>'Crear IPC', 'url'=>array('create')),
	array('label'=>'Ver IPC', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar IPC', 'url'=>array('admin')),
);
?>
<div class="span10">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>