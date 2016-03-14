<?php
/* @var $this IpcController */
/* @var $model Ipc */


$this->breadcrumbs = array(
    'IPCs' ,
);

$this->menu=array(
	array('label'=>'Crear Ipc', 'url'=>array('create')),
);

?>


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
