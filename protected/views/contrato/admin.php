<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Contratos'=>array('admin'),
	'Administrar',
);

if(Yii::app()->user->rol != 'propietario' && Yii::app()->user->rol != 'cliente'){
    $this->menu=array(
	array('label'=>'Crear Contrato', 'url'=>array('create')),
    );
}



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
<h1>Administrar Contratos</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php 
if(Yii::app()->user->rol != 'propietario' && Yii::app()->user->rol != 'cliente'){    
    echo CHtml::link('Exportar a Excel',CController::createUrl("/contrato/exportarXLS"),array('class'=>'')); 
}
?></div>
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
		array('name'=>'monto_renta','value'=>'Tools::formateaPlata($data->monto_renta)'),
                array('name'=>'monto_gastocomun','value'=>'Tools::formateaPlata($data->monto_gastocomun)'),
                array('name'=>'monto_mueble','value'=>'Tools::formateaPlata($data->monto_mueble)'),
                array('name'=>'monto_gastovariable','value'=>'Tools::formateaPlata($data->monto_gastovariable)'),
                array('name'=>'monto_castigado','value'=>'Tools::formateaPlata($data->monto_castigado)'),
                array('name'=>'monto_primer_mes','value'=>'Tools::formateaPlata($data->monto_primer_mes)'),
                array('name'=>'dias_primer_mes','value'=>'$data->dias_primer_mes'),
                array('name'=>'monto_cheque','value'=>'Tools::formateaPlata($data->monto_cheque)'),
		'plazo',
		array('name'=>'depto_nombre','value'=>'$data->departamento->numero'),
                array('name'=>'propiedad_nombre','value'=>'$data->departamento->propiedad->nombre'),
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
                        'visible'=>Yii::app()->user->rol == 'cliente' || Yii::app()->user->rol == 'propietario',
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
	),
)); 


Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {
	$('#datepicker_for_fecha').datepicker($.datepicker.regional[ 'es' ]);
}
");
?>
