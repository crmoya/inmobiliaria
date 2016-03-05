<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */
/* @var $form CActiveForm */
?>
<script>
$(document).ready(function(e){
    window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
});
</script> 
<div class="span12">

   <?php
   $form = $this->beginWidget('CActiveForm', array(
       'id' => 'movimiento-form',
       'enableAjaxValidation' => false,
   ));
   ?>

      <?php echo $form->errorSummary($model); ?>

   <div class="span2">
      <?php echo $form->labelEx($model, 'fecha'); ?>
      <?php
      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model' => $model,
          'attribute' => 'fecha',
          'language' => 'es',
          'options' => array(
              'dateFormat' => 'yy-mm-dd',
          ),
          'htmlOptions' => array(
              'size' => '10', // textField size
              'maxlength' => '10', // textField maxlength
              'readonly'=>'readonly',
          ),
      ));
      ?>
      <?php echo $form->error($model, 'fecha'); ?>
   </div>

   <div class="span2">
      <?php echo $form->labelEx($model, 'monto'); ?>
      <?php echo $form->textField($model, 'monto',array('class'=>'fixed')); ?>
<?php echo $form->error($model, 'monto'); ?>
   </div>

    <?php if($model->tipo == Tools::MOVIMIENTO_TIPO_ABONO):?>
   
    <div class="clearfix"></div>
    <div class="span2">
      <?php echo $form->labelEx($model, 'forma_pago_id'); ?>
      <?php echo $form->dropDownList($model, 'forma_pago_id', 
                        CHtml::listData(FormaPago::model()->findAll(),'id','nombre'),array('empty'=>'Seleccione Forma Pago')); ?>
      <?php echo $form->error($model, 'forma_pago_id'); ?>
   </div>

    <?php endif;?>
    <div class="clearfix"></div>
    <div class="span4">
      <?php echo $form->labelEx($model, 'detalle'); ?>
      <?php echo $form->textField($model, 'detalle', array('size' => 60, 'maxlength' => 200,'style'=>'width:325px !important;')); ?>
<?php echo $form->error($model, 'detalle'); ?>
   </div>
    <div class="clearfix"></div>
    
<br/>
   <div class="span2 buttons">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
   </div>

    
   <div class="span2">
       <input type="hidden" name="mov_id" value="<?php echo $model->id; ?>" />
       <input type="hidden" name="cuenta_id" value="<?php echo $model->cuenta_corriente_id; ?>" />
   </div>
    <br/>
    <div class="clearfix"></div>
   <?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(document).ready(function(e){
    $('.fixed').change(function(e) {
        var text = $(this).val();
        text = text.replace(',','.');
        if(!isNaN(text)){
            var num = new Number(text);
            num = num.toFixed(0);
            $(this).val(num);
        }else{
            $(this).val(0);
        }
    });
});
</script>