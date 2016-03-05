<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Contratos vigentes',
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
		array('name'=>'propiedad_nombre','value'=>'$data->departamento->propiedad->nombre'),
                array('name'=>'depto_nombre','value'=>'$data->departamento->numero'),
		array('name'=>'cliente_nombre','value'=>'$data->cliente->usuario->nombre." ".$data->cliente->usuario->apellido'),
                array('name'=>'cliente_rut','value'=>'$data->cliente->rut'),
                array(
			'class'=>'CButtonColumn',
                        'visible'=>Yii::app()->user->rol == 'propietario',
                        'template'=>'{view}{agregar}',
                        'header'=>'Cargar',
                        'buttons'=>array(
                            'agregar'=>array(
                               'label'=>'Cargar esta cuenta',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/sub.png',
                               'url'=>'Yii::app()->createUrl("//movimiento/cargar/", array("id"=>$data->cuentaCorriente->id))',
                            ),
                            'view'=>array(
                               'imageUrl'=>Yii::app()->baseUrl.'/images/lista.png',
                               'label'=>'Ver movimientos de esta cuenta',
                               'url'=>'Yii::app()->createUrl("//movimiento/viewDetail/", array("id"=>$data->cuentaCorriente->id))',
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
