<?php
/* @var $this CentroCostoController */
/* @var $model CentroCosto */

$this->breadcrumbs=array(
	'Centros de Costos'
);

$this->menu=array(
	array('label'=>'Crear Centro de Costo', 'url'=>array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'centro-costo-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'nombre',
                array(
                    'name'=>'carga_a',
                    'value'=>'Tools::backCargaA($data->carga_a)',
                    'filter'=>CHtml::listData(array(
                        array('id'=>'1','nombre'=>'PROPIEDAD'),
                        array('id'=>'2','nombre'=>'DEPARTAMENTO'),
                        array('id'=>'3','nombre'=>'INMOBILIARIA'),
                    ),'id','nombre'),
                ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
