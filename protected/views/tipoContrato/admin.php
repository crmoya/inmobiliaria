<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */

$this->breadcrumbs=array(
	'Formatos de Contratos'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Nuevo Formato de Contrato', 'url'=>array('create')),
);
?>

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
