<?php
/* @var $this ClienteController */
/* @var $model Cliente */


$this->breadcrumbs = array(
    'Ingresar Nuevo Cliente',
);
$this->menu=array(
	array('label'=>'Administrar Cliente', 'url'=>array('admin')),
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
