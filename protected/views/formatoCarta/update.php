<?php
/* @var $this FormatoCartaController */
/* @var $model FormatoCarta */

$this->breadcrumbs=array(
	'Formato Cartas'=>array('admin'),
	$model->id=>array('view','id'=>$model->id),
	'Actualizar',
);

$this->menu=array(
	array('label'=>'Crear Formato Carta', 'url'=>array('create')),
	array('label'=>'Ver Formato Carta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Formato Carta', 'url'=>array('admin')),
);
?>

<h1>Actualizar Formato Carta <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>