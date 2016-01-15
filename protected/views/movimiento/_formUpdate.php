<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */
/* @var $form CActiveForm */
?>

<div class="form">

   <?php
   $form = $this->beginWidget('CActiveForm', array(
       'id' => 'movimiento-form',
       'enableAjaxValidation' => false,
   ));
   ?>

   <p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

      <?php echo $form->errorSummary($model); ?>

   <div class="row">
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

   <div class="row">
      <?php echo $form->labelEx($model, 'monto'); ?>
      <?php echo $form->textField($model, 'monto'); ?>
<?php echo $form->error($model, 'monto'); ?>
   </div>

   <div class="row">
      <?php echo $form->labelEx($model, 'detalle'); ?>
      <?php echo $form->textField($model, 'detalle', array('size' => 60, 'maxlength' => 200)); ?>
<?php echo $form->error($model, 'detalle'); ?>
   </div>

   <div class="row">
       <input type="hidden" name="mov_id" value="<?php echo $model->id; ?>" />
       <input type="hidden" name="cuenta_id" value="<?php echo $cuenta_cte; ?>" />
   </div>

   <div class="row buttons">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
   </div>

   <?php $this->endWidget(); ?>

</div><!-- form -->