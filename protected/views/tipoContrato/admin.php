<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Tipo Contratos'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Crear Tipo de Contrato', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('tipo-contrato-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Tipos de Contratos</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/tipoContrato/exportarXLS"),array('class'=>'')); ?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'tipo-contrato-grid',
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
