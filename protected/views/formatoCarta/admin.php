<?php
/* @var $this FormatoCartaController */
/* @var $model FormatoCarta */

$this->breadcrumbs=array(
	'Formato Carta'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Crear Formato Carta', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('formato-carta-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Formato Carta</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/formatoCarta/exportarXLS"),array('class'=>'')); ?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'formato-carta-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{view}{delete}',
		),
	),
)); ?>
