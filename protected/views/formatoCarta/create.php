<?php
/* @var $this FormatoCartaController */
/* @var $model FormatoCarta */

$this->breadcrumbs=array(
	'Formato Carta'=>array('admin'),
	'Crear',
);

$this->menu=array(
	array('label'=>'Administrar Formato Carta', 'url'=>array('admin')),
);
?>

<h1>Crear Formato de Carta</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>