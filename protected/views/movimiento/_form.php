<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */
/* @var $form CActiveForm */
?>

<div class="span12">

   <?php
   $form = $this->beginWidget('CActiveForm', array(
       'id' => 'movimiento-form',
       'enableAjaxValidation' => false,
   ));
   ?>

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
            <?php echo $form->labelEx($model, 'concepto_id'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'concepto_id', $conceptos, array('empty' => 'Seleccione un Concepto',)
            );
            ?>
            <?php echo $form->error($model, 'concepto_id'); ?>
   </div>

   <div class="row">
      <?php 
      echo $form->hiddenField($model,'cuenta_corriente_id',array('value'=>8));
      ?>
   </div>

   <div class="row buttons">
      <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
   </div>

   <?php $this->endWidget(); ?>

</div><!-- form -->