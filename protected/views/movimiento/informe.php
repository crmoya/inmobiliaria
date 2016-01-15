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

      <?php echo $form->errorSummary($model); ?>

   <div class="row">
      <?php echo $form->labelEx($model, 'fechaDesde'); ?>
      <?php
      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model' => $model,
          'attribute' => 'fechaDesde',
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
      <?php echo $form->error($model, 'fechaDesde'); ?>
   </div>
<div class="row">
      <?php echo $form->labelEx($model, 'fechaHasta'); ?>
      <?php
      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model' => $model,
          'attribute' => 'fechaHasta',
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
      <?php echo $form->error($model, 'fechaHasta'); ?>
   </div>

   <div class="row buttons">
      <?php echo CHtml::submitButton('Crear Informe',array('class'=>'btn')); ?>
   </div>

   <?php $this->endWidget(); ?>

</div><!-- form -->