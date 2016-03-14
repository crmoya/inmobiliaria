<?php
/* @var $this TipoPrestacionController */
/* @var $model TipoPrestacion */


$this->breadcrumbs = array(
    'Tipos Prestaciones' => array('admin'),
    'Nuevo Tipo de Prestación',
);
$this->menu=array(
	array('label'=>'Administrar Tipo de Prestación', 'url'=>array('admin')),
);
?>
<div class="span10">

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>