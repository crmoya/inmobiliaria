<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */

$this->breadcrumbs=array(
	'Propiedades'=>array('admin'),
	'Administrar',
);

if(Yii::app()->user->rol != 'propietario'){
    $this->menu=array(
        array('label'=>'Crear Propiedad', 'url'=>array('create')),
    );
}


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('propiedad-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Propiedades</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<?php if(Yii::app()->user->rol != 'propietario'): ?>
    <div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/propiedad/exportarXLS"),array('class'=>'')); ?></div>
<?php endif;?>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php 
if(Yii::app()->user->rol != 'propietario'){
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'propiedad-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'propietario_nom', 'value'=>'$data->propietario!=null?$data->propietario->rut:""'),
		'nombre',
		'direccion',
		'mt_construidos',
		'mt_terreno',
		'cant_estacionamientos',
		'inscripcion',
		array(
			'class'=>'CButtonColumn',
		),
	),
    ));
}else{
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'propiedad-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'direccion',
		'mt_construidos',
		'mt_terreno',
		'cant_estacionamientos',
		'inscripcion',
	),
    ));
}
?>
