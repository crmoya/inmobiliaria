<?php
/* @var $this FormatoCartaController */
/* @var $model FormatoCarta */

$this->breadcrumbs=array(
	'Formato de Cartas'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Formato de Carta', 'url'=>array('create')),
	array('label'=>'Borrar Formato de Carta', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'¿Está seguro de eliminar este item?')),
	array('label'=>'Administrar Formato de Carta', 'url'=>array('admin')),
);
?>

<h1>Formato Carta #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'nombre',
	),
)); ?>