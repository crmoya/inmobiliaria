<?php
/* @var $this FiadorController */
/* @var $model Fiador */

$this->breadcrumbs=array(
	'Fiadors'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Fiador', 'url'=>array('index')),
	array('label'=>'Create Fiador', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#fiador-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Fiadors</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'fiador-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'rut',
		'ap_paterno',
		'ap_materno',
		'nombre',
		'email',
		/*
		'telefono',
		'direccion',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
