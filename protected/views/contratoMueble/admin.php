<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Contratos'=>array('admin'),
	'Administrar',
);

if(Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo'  || Yii::app()->user->rol == 'propietario'){
    $this->menu=array(
	array('label'=>'Crear Contrato Bienes Muebles', 'url'=>array('create')),
);
}
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
		array('name'=>'propiedad_nombre','value'=>'$data->contrato->departamento->propiedad->nombre'),
		array('name'=>'depto_nombre','value'=>'$data->contrato->departamento->numero'),
                array('name'=>'cliente_rut','value'=>'$data->contrato->cliente->rut'),
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
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{view}{delete}',
                        'header'=>'Acciones',
                        'buttons'=>array(
                            'view'=>array(
                               'label'=>'Ver imagen de este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/imagen.png',
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
