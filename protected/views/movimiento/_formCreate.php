<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */
/* @var $form CActiveForm */
?>

<div class="span10">

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

   <div class="span3">
      <?php echo $form->labelEx($model, 'tipo'); ?>
      <?php
      echo $form->dropDownList(
              $model, 'tipo', $model->getTypeMovOptions(), array('empty' => 'Seleccione un tipo de Movimiento',)
      );
      ?>
<?php echo $form->error($model, 'tipo'); ?>
   </div>

    
   <div class="span2">
      <?php echo $form->labelEx($model, 'monto'); ?>
      <?php echo $form->textField($model, 'monto'); ?>
<?php echo $form->error($model, 'monto'); ?>
   </div>
    
    
   
<div class="clearfix"></div>
   
<div class="span5">
      <?php echo $form->labelEx($model, 'detalle'); ?>
      <?php echo $form->textField($model, 'detalle', array('size' => 100, 'maxlength' => 200,'style'=>'width:410px !important;')); ?>
<?php echo $form->error($model, 'detalle'); ?>
   </div>
   <div class="span2">
      <?php echo $form->labelEx($model, 'forma_pago_id'); ?>
      <?php echo $form->dropDownList($model, 'forma_pago_id', 
                        CHtml::listData(FormaPago::model()->findAll(),'id','nombre'),array('empty'=>'Selecione Forma Pago')); ?>
      <?php echo $form->error($model, 'forma_pago_id'); ?>
   </div>
<div class="clearfix"></div>
<br>
   <div class="span2 buttons">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
   </div>
<div class="clearfix"></div>

   <?php $this->endWidget(); ?>

</div><!-- form -->