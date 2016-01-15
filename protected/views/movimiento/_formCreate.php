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
      <?php echo $form->labelEx($model, 'tipo'); ?>
      <?php
      echo $form->dropDownList(
              $model, 'tipo', $model->getTypeMovOptions(), array('empty' => 'Seleccione un tipo de Movimiento',)
      );
      ?>
<?php echo $form->error($model, 'tipo'); ?>
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
      <?php echo $form->labelEx($model, 'forma_pago'); ?>
      <?php echo $form->textField($model, 'forma_pago', array('size' => 60, 'maxlength' => 100)); ?>
      <?php echo $form->error($model, 'forma_pago'); ?>
   </div>
   <div class="row buttons">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
   </div>

   <?php $this->endWidget(); ?>

</div><!-- form -->