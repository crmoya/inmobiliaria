<?php
/* @var $this ReajusteRentaController */
/* @var $model ReajusteRenta */

$this->breadcrumbs=array(
	'Reajustes de Rentas'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Editar',
);

$this->menu=array(
	array('label'=>'Crer Reajuste de Renta', 'url'=>array('create')),
	array('label'=>'Ver Reajuste de Renta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Reajuste de Renta', 'url'=>array('admin')),
);
?>

<h1>Editar Reajuste de Renta <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>