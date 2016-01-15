<?php
/* @var $this IpcController */
/* @var $model Ipc */

$this->menu=array(
	array('label'=>'Crear Ipc', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#ipc-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Ipcs</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php echo CHtml::link('Exportar a Excel',CController::createUrl("/ipc/exportarXLS"),array('class'=>'')); ?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'ipc-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'enableSorting' => false,
	'columns'=>array(
		'porcentaje',
		array(  'name'=>'mes',
                        'value'=>'Tools::fixMes($data->mes)',
                        'filter' => CHtml::listData( array(
                                        array('id'=>'1','nombre'=>'ENERO'),
                                        array('id'=>'2','nombre'=>'FEBRERO'),
                                        array('id'=>'3','nombre'=>'MARZO'),
                                        array('id'=>'4','nombre'=>'ABRIL'),
                                        array('id'=>'5','nombre'=>'MAYO'),
                                        array('id'=>'6','nombre'=>'JUNIO'),
                                        array('id'=>'7','nombre'=>'JULIO'),
                                        array('id'=>'8','nombre'=>'AGOSTO'),
                                        array('id'=>'9','nombre'=>'SEPTIEMBRE'),
                                        array('id'=>'10','nombre'=>'OCTUBRE'),
                                        array('id'=>'11','nombre'=>'NOVIEMBRE'),
                                        array('id'=>'12','nombre'=>'DICIEMBRE'),
                                    ), 'id', 'nombre'),
                    ),
                'agno',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 



?>
