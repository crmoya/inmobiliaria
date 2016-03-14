<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Formatos de Demanda'
);

$this->menu=array(
	array('label'=>'Crear Formato de Demanda', 'url'=>array('create')),
);
?>
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'formato-demanda-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(
			'class'=>'CButtonColumn',
                    'template'=>'{view} {delete}',
		),
	),
)); ?>
