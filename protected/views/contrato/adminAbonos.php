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
                        'template'=>'{view} {excel}',
                        'header'=>'Cargos/Abonos',
                        'buttons'=>array(
                            'view'=>array(
                               'label'=>'Ver movimientos de esta cuenta',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/lista.png',
                               'url'=>'Yii::app()->createUrl("//movimiento/viewDetail/", array("id"=>$data->cuentaCorriente->id))',
                            ),
                            'excel'=>array(
                               'label'=>'Consultar movimientos entre fechas para este cliente',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/excel.png',
                               'url'=>'$data->id',
                               'click'=>'function(){'
                                . 'var contrato_id=$(this).attr("href");'
                                . '$("#contrato_id").val(contrato_id);'
                                . '$("#mydialog").dialog("open"); return false;'
                                . '}',
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


<?php

$this->beginWidget('zii.widgets.jui.CJuiDialog',array(
    'id'=>'mydialog',
    // additional javascript options for the dialog plugin
    'options'=>array(
        'title'=>'Movimientos de Cliente',
        'autoOpen'=>false,
        'width'=>'700px',
    ),
));
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'movimiento-form',
    'enableAjaxValidation' => false,
));

?>
    <div class="span2">Fecha Desde</div>
    <div class="clearfix"></div>
    <div class="span3">
        <?php echo $form->hiddenField($filtroModel,'contratoId',array('id'=>'contrato_id'));?>
        <?php echo $form->labelEx($filtroModel, 'mesD'); ?>
        <?php
        echo $form->dropDownList(
                $filtroModel, 'mesD', CHtml::listData($meses,'id','nombre'), array('empty' => 'Seleccione mes',)
        );
        ?>
        <?php echo $form->error($filtroModel, 'mesD'); ?>
    </div>
    <div class="span3">
        <?php echo $form->labelEx($filtroModel, 'agnoD'); ?>
        <?php
        echo $form->dropDownList(
                $filtroModel, 'agnoD', CHtml::listData($agnos,'id','nombre'), array('empty' => 'Seleccione año',)
        );
        ?>
        <?php echo $form->error($filtroModel    , 'agno'); ?>
    </div>
    <div class="clearfix"></div>
    <div class="span2">Fecha Hasta</div>
    <div class="clearfix"></div>
    <div class="span3">
        <?php echo $form->labelEx($filtroModel, 'mesH'); ?>
        <?php
        echo $form->dropDownList(
                $filtroModel, 'mesH', CHtml::listData($meses,'id','nombre'), array('empty' => 'Seleccione mes',)
        );
        ?>
        <?php echo $form->error($filtroModel, 'mesH'); ?>
    </div>
    <div class="span3">
        <?php echo $form->labelEx($filtroModel, 'agnoH'); ?>
        <?php
        echo $form->dropDownList(
                $filtroModel, 'agnoH', CHtml::listData($agnos,'id','nombre'), array('empty' => 'Seleccione año',)
        );
        ?>
        <?php echo $form->error($filtroModel    , 'agnoH'); ?>
    </div>
    <div class="clearfix"></div>
    <div class="span2">
        <?php echo $form->labelEx($filtroModel,'conDetalle');?>
        <?php echo $form->checkbox($filtroModel,'conDetalle');?>
        <?php echo $form->error($filtroModel,'conDetalle');?>
    </div>
    <div class="span2">
        <?php echo $form->labelEx($filtroModel,'desdeInicio');?>
        <?php echo $form->checkbox($filtroModel,'desdeInicio');?>
        <?php echo $form->error($filtroModel,'desdeInicio');?>
    </div>
    <div class="span2">
        <?php echo $form->labelEx($filtroModel,'desdeSaldo0');?>
        <?php echo $form->checkbox($filtroModel,'desdeSaldo0');?>
        <?php echo $form->error($filtroModel,'desdeSaldo0');?>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="span2">
        <?php echo CHtml::submitButton('Estado Cuenta',array('id'=>'estado_cuenta','class'=>'btn')); ?>
    </div>
<?php
$this->endWidget(); 
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<script>
$(document).ready(function(e){
    $('#estado_cuenta').click(function(e){
        $("#mydialog").dialog("close");
    });
});
</script>