<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Contratos Vigentes',
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
                        'visible'=>Yii::app()->user->rol == 'superusuario',
                        'template'=>'{view} {update} {download} {delete}',
                        'header'=>'Acciones',
                        'buttons'=>array(
                            'view'=>array(
                               'label'=>'Ver imagen de este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/imagen.png',
                            ),
                            'update'=>array(
                               'label'=>'Firmar este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/contrato.png',
                            ),
                            'download'=>array(
                               'label'=>'Descargar este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/download.png',
                               'url'=>'Yii::app()->createUrl("//contrato/download", array("id"=>$data->id))',
                            ),
                            
                        ),
		),
                array(
			'class'=>'CButtonColumn',
                        'visible'=>Yii::app()->user->rol == 'propietario',
                        'template'=>'{view}{update}{download}{viewCliente}{historial}',
                        'header'=>'Acciones',
                        'buttons'=>array(
                            'view'=>array(
                               'label'=>'Ver imagen de este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/imagen.png',
                            ),
                            'update'=>array(
                               'label'=>'Firmar este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/contrato.png',
                            ),
                            'download'=>array(
                               'label'=>'Descargar este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/download.png',
                               'url'=>'Yii::app()->createUrl("//contrato/download", array("id"=>$data->id))',
                            ),
                            'viewCliente'=>array(
                               'label'=>'Ver datos del Arrendatario',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/person.png',
                               'url'=>'Yii::app()->createUrl("//contrato/viewCliente", array("id"=>$data->id))',
                            ),
                            'historial'=>array(
                               'label'=>'Ver historial de reajustes para este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/lista.png',
                               'url'=>'Yii::app()->createUrl("//debePagar/view", array("id"=>$data->id))',
                            ),
                        ),
		),
                array(
			'class'=>'CustomCButtonColumn',
                        'visible'=>Yii::app()->user->rol == 'propietario',
                        'template'=>'{reajusta}',
                        'header'=>'¿Debe Reajustar?',
                        'buttons'=>array(
                            'reajusta'=>array(
                               'label'=>'Hacer que este contrato reajuste/no reajuste',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/pesoVerde.png',
                               'url'=>'Yii::app()->createUrl("//contrato/reajusta", array("id"=>$data->id))',
                            ),
                            
                        ),
		),
                array(
			'class'=>'CButtonColumn',
                        'visible'=>Yii::app()->user->rol == 'cliente',
                        'template'=>'{view} {download}',
                        'header'=>'Acciones',
                        'buttons'=>array(
                            'view'=>array(
                               'label'=>'Ver imagen de este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/imagen.png',
                            ),
                            'download'=>array(
                               'label'=>'Descargar este contrato',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/download.png',
                               'url'=>'Yii::app()->createUrl("//contrato/download", array("id"=>$data->id))',
                            ),
                            
                        ),
		),
                array(
			'class'=>'CButtonColumn',
                        'visible'=>Yii::app()->user->rol == 'propietario',
                        'template'=>'{finiquitar}',
                        'header'=>'Finiquitar',
                        'buttons'=>array(
                            'finiquitar'=>array(
                                'url'=>'Yii::app()->createUrl("//contrato/finiquitar", array("id"=>$data->id))',
                                'label'=>'Finiquitar este contrato',
                                'imageUrl'=>Yii::app()->baseUrl.'/images/eliminar.png',
                                'click'=>'function(){'
                                . 'var url = $(this).attr("href");'
                                . 'swal({   '
                                . '         title: "Seguro desea finiquitar este contrato?",   '
                                . '         text: "Esta acción no se puede deshacer",   '
                                . '         type: "warning",   '
                                . '         cancelButtonText: "Cancelar",'
                                . '         showCancelButton: true,   '
                                . '         confirmButtonColor: "#DD6B55",  '
                                . '         confirmButtonText: "Sí, finiquitarlo",   '
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
