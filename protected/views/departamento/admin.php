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
?>
<?php if(Yii::app()->user->rol != 'propietario' && Yii::app()->user->rol != 'cliente'): ?>
<div class="span8"></div><div class="span3"><?php echo CHtml::link("Crear nuevo departamento",array('//departamento/create'));?></div>
<div class="clearfix"><br/><br/></div>
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
