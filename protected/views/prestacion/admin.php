<?php
/* @var $this PrestacionController */
/* @var $model Prestacion */


$this->breadcrumbs=array(
	'Prestaciones'
);
$this->menu=array(
	array('label'=>'Nueva Prestación', 'url'=>array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'prestacion-grid',
	'dataProvider'=>$model->search(),
        'afterAjaxUpdate' => 'reinstallDatePicker',
	'filter'=>$model,
	'columns'=>array(
		array(            
                    'name'=>'fecha',
                    'value'=>array($model,'gridDataColumn'),
                    'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model'=>$model, 
                        'attribute'=>'fecha', 
                        'language' => 'es',
                        'htmlOptions' => array(
                            'id' => 'datepicker_for_fecha',
                            'size' => '10',
                        ),
                        'defaultOptions' => array(  // (#3)
                            'showOn' => 'focus', 
                            'dateFormat' => 'dd/mm/yy',
                            'showOtherMonths' => true,
                            'selectOtherMonths' => true,
                            'changeMonth' => true,
                            'changeYear' => true,
                            'showButtonPanel' => true,
                          )
                        ), 
                    true), 
                ),
		'monto',
		'documento',
		'descripcion',
                array('name'=>'tipo_prestacion_nombre', 'value'=>'$data->tipoPrestacion->nombre'),
		array('name'=>'ejecutor_nombre', 'value'=>'$data->ejecutor->nombre'),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); 


Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
	$('#datepicker_for_fecha').datepicker($.datepicker.regional[ 'es' ]);
}
");


?>
