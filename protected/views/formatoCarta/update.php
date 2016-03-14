<?php
/* @var $this FormatoCartaController */
/* @var $model FormatoCarta */

$this->breadcrumbs=array(
	'Formatos de Cartas'=>array('admin'),
	$model->id=>array('view','id'=>$model->id)
);

$this->menu=array(
	array('label'=>'Crear Formato Carta', 'url'=>array('create')),
	array('label'=>'Ver Formato Carta', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Formato Carta', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>