<?php
/* @var $this FormatoCartaController */
/* @var $model FormatoCarta */

$this->breadcrumbs=array(
	'Formatos de Cartas',
);

$this->menu=array(
	array('label'=>'Crear Formato Carta', 'url'=>array('create')),
);
?>
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
