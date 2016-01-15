<?php
/* @var $this ReajusteRentaController */
/* @var $model ReajusteRenta */

$this->breadcrumbs=array(
	'Reajuste Rentas'=>array('admin'),
	'Create',
);

$this->menu=array(
	array('label'=>'Administrar Reajustes de Renta', 'url'=>array('admin')),
);
?>

<h1>Crear Reajuste de Renta</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>