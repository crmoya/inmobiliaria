<?php
/* @var $this MuebleController */
/* @var $model Mueble */

$this->breadcrumbs=array(
	'Muebles'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Crear Bien Mueble', 'url'=>array('create')),
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'mueble-grid',
	'dataProvider'=>$model->search(),
        'afterAjaxUpdate' => 'reinstallDatePicker',
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		array(            
                    'name'=>'fecha_compra',
                    'value'=>array($model,'gridDataColumn'),
                    'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model'=>$model, 
                        'attribute'=>'fecha_compra', 
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
                array('name'=>'propiedad_nom', 'value'=>'$data->departamento->propiedad->nombre'),
		array('name'=>'departamento_num', 'value'=>'$data->departamento->numero'),
		array(
                    'class'=>'CButtonColumn',
                    'template'=>'{update}{delete}',
		),
	),
)); 

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
	$('#datepicker_for_fecha').datepicker($.datepicker.regional[ 'es' ]);
}
");

?>

