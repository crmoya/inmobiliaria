<?php
/* @var $this CuentaCorrienteController */
/* @var $model CuentaCorriente */

$this->breadcrumbs=array(
	'Cuenta Corrientes'=>array('admin'),
	'Administrar',
);
/*
$this->menu=array(
	array('label'=>'Crear CuentaCorriente', 'url'=>array('create')),
);
 * 
 */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('cuenta-corriente-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Cuentas Corrientes</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/contrato/exportarXLS"),array('class'=>'')); ?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cuenta-corriente-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'saldo_inicial',
                'nombre',
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{view}',
		),
	),
)); ?>
