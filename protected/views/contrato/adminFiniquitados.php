<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Contratos Finiquitados',
);

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
<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'contrato-grid',
	'dataProvider'=>$model->searchFiniquitados(),
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
		array('name'=>'propiedad_nombre','value'=>'$data->departamento->propiedad->nombre'),
                array('name'=>'depto_nombre','value'=>'$data->departamento->numero'),
		array('name'=>'cliente_nombre','value'=>'$data->cliente->usuario->nombre." ".$data->cliente->usuario->apellido'),
                array('name'=>'cliente_rut','value'=>'$data->cliente->rut'),
                'fecha_finiquito',
                array(
			'class'=>'CButtonColumn',
                        'visible'=>Yii::app()->user->rol == 'propietario',
                        'template'=>'{liquidar}',
                        'header'=>'Liquidación de Garantía',
                        'buttons'=>array(
                            'liquidar'=>array(
                                'url'=>'Yii::app()->createUrl("//contrato/liquidar", array("id"=>$data->id))',
                                'label'=>'Liquidación de garantía para este contrato',
                                'imageUrl'=>Yii::app()->baseUrl.'/images/factura.jpg',
                                'click'=>'function(){'
                                . 'var url = $(this).attr("href");'
                                . 'swal({   '
                                . '         title: "Desea realizar la liquidación de garantía para este contrato?",   '
                                . '         type: "warning",   '
                                . '         cancelButtonText: "Cancelar",'
                                . '         showCancelButton: true,   '
                                . '         confirmButtonColor: "#DD6B55",  '
                                . '         confirmButtonText: "Sí, liquidar",   '
                                . '         closeOnConfirm: true }, '
                                . '         function(){   '
                                . '             window.location = url;'
                                . '         });'
                                . 'return false;}',
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
