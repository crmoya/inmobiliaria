<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */

$this->breadcrumbs=array(
	'Ejecutores'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Crear Ejecutor', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ejecutor-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Ejecutores</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/ejecutor/exportarXLS"),array('class'=>'')); ?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ejecutor-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rut',
		'nombre',
		'direccion',
		'telefono',
		'email',
		'especialidad',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
