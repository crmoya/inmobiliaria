<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs=array(
	'Departamentos'=>array('admin'),
	'Administrar',
);
if(Yii::app()->user->rol != 'propietario' && Yii::app()->user->rol != 'cliente'){
$this->menu=array(
	array('label'=>'Crear Departamento', 'url'=>array('create')),
);
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('departamento-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Departamentos</h1>
<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<?php if(Yii::app()->user->rol != 'propietario' && Yii::app()->user->rol != 'cliente'): ?>
    <div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/departamento/exportarXLS"),array('class'=>'')); ?></div>
<?php endif; ?>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<?php if(Yii::app()->user->rol != 'propietario' && Yii::app()->user->rol != 'cliente'): ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'departamento-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'propiedad_nombre','value'=>'$data->propiedad->nombre'),
		'numero',
		'mt2',
		'dormitorios',
		'estacionamientos',
		'renta',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
<?php else: ?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'departamento-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'propiedad_nombre','value'=>'$data->propiedad->nombre'),
		'numero',
		'mt2',
		'dormitorios',
		'estacionamientos',
		'renta',
	),
)); ?>
<?php endif;?>
