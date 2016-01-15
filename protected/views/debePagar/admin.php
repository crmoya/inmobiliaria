<?php
/* @var $this ContratoController */
/* @var $model Contrato */


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('contrato-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, // use transitions?
    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
      ),)
); ?>
<script>
$(document).ready(function(e){
    window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
});
</script> 
<h3>Seleccione un contrato para ver su historial de reajustes</h3>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contrato-grid',
	'dataProvider'=>$model->search(),
        'afterAjaxUpdate' => 'reinstallDatePicker',
	'filter'=>$model,
	'columns'=>array(
		'folio',
		array(            
                    'name'=>'fecha_inicio',
                    'value'=>array($model,'gridDataColumn'),
                    'filter' => $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model'=>$model, 
                        'attribute'=>'fecha_inicio', 
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
		'monto_renta',
		'monto_gastocomun',
		'plazo',
		array('name'=>'depto_nombre','value'=>'$data->departamento->numero'),
                array('name'=>'propiedad_nombre','value'=>'$data->departamento->propiedad->nombre'),
		array('name'=>'cliente_rut','value'=>'$data->cliente->rut'),
                array('name'=>'cliente_nombre','value'=>'$data->cliente->usuario->nombre." ".$data->cliente->usuario->apellido '),
		array('name'=>'tipo_nombre','value'=>'$data->tipoContrato->nombre'),
                array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}',
                        'header'=>'Ver',
                        'buttons'=>array(
                            'view'=>array(
                               'label'=>'Visualizar reajustes de este contrato',
                               'url'=>'Yii::app()->createUrl("debePagar/view", array("id"=>$data->id))',
                            ),
                        ),
		),
	),
)); 


Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
	$('#datepicker_for_fecha').datepicker($.datepicker.regional[ 'es' ]);
}
");
?>