<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Enviar cartas de aviso',
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
	'dataProvider'=>$model->searchAvisos(),
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
			'class'=>'ButtonColumn',
                        'template'=>'{send}{download}',
                        'header'=>'Cartas Aviso',
                        'evaluateID'=>true,
                        'buttons'=>array(
                            'send'=>array(
                               'label'=>'Enviar carta de aviso',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/sobre.png',
                               'options'=>array(
                                   'id'=>'$data->id',
                               ),
                            ),
                            'download'=>array(
                               'label'=>'Visualizar esta carta',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/download.png',
                               'url'=>'Yii::app()->createUrl("//contrato/descargarCarta", array("id"=>$data->id))',
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


<?php $this->beginWidget('bootstrap.widgets.TbModal', array('id'=>'modal_aviso')); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Escoja un tipo de carta de aviso para enviar a <span id="nombre_cliente"></span></h4>
</div>
 
<div class="modal-body">
    <?php $form=$this->beginWidget('CActiveForm', array(
            'id'=>'tipo-carta-form',
            'enableAjaxValidation'=>false,
    )); ?>
        <div class="row" style="padding-left:50px;">
            <?php echo $form->labelEx($formato,'formatoCarta'); ?>
            <?php echo $form->dropDownList(
                                $formato,'formato', CHtml::listData(FormatoCarta::model()->findAll(), 'id', 'nombre'),
                                array('prompt'=>'Seleccione un Formato')); ?>
            <?php echo $form->error($formato,'nombre'); ?>
            <?php echo $form->hiddenField($formato,'contrato_id', array('id'=>'contrato_id')); ?>
        </div>  
        
    <?php $this->endWidget(); ?>
</div>
 
<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Enviar',
        'url'=>  '#',
        'htmlOptions'=>array('data-dismiss'=>'modal','onclick'=>'$("#tipo-carta-form").submit()'),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Cancelar',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>
</div>
 
<?php $this->endWidget(); ?>
<script>
$(document).ready(function(e){
    $('.button-column a').click(function(e){
        var contrato_id = $(this).attr('id');
        $('#contrato_id').attr('value',contrato_id);
        $.ajax({
            type: 'POST',
            url: '<?php echo CController::createUrl('//contrato/getNombreCliente/');?>',
            data: { contrato_id: contrato_id },
            success: function (msg) {
                if(msg != 'ERROR'){
                    $("#nombre_cliente").html(msg);
                    $('#modal_aviso').modal('show');
                }
                else{
                    alert('ERROR: no se puede enviar la carta de aviso a este contrato.');
                }
            }
        });
    });
});
</script>