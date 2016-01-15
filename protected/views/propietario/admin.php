<?php
/* @var $this PropietarioController */
/* @var $model Propietario */

$this->breadcrumbs=array(
	'Propietarios'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Crear Propietario', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#propietario-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Propietarios</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/propietario/exportarXLS"),array('class'=>'')); ?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'propietario-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
                'rut',
                array('name'=>'nombre', 'value'=>'$data->usuario->nombre'),
                array('name'=>'apellido', 'value'=>'$data->usuario->apellido'),
                array('name'=>'email', 'value'=>'$data->usuario->email'),
                'direccion',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
