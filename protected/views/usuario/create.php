<?php
$this->menu=array(
	array('label'=>'Administrar Usuarios', 'url'=>array('admin')),
);

$this->breadcrumbs = array(
    'Usuarios' => array('admin'),
    'Nuevo Usuario',
);
?>
<div class="span10">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>