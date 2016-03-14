<?php
/* @var $this FormatoCartaController */
/* @var $model FormatoCarta */

$this->breadcrumbs=array(
	'Formatos de Carta'=>array('admin'),
	'Nuevo formato',
);

$this->menu=array(
	array('label'=>'Administrar Formato Carta', 'url'=>array('admin')),
);
?>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>