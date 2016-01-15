<?php
/* @var $this PagoMesController */
/* @var $model PagoMes */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'pago-mes-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'contrato_id'); ?>
		<?php echo $form->textField($model,'contrato_id'); ?>
		<?php echo $form->error($model,'contrato_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto_renta'); ?>
		<?php echo $form->textField($model,'monto_renta'); ?>
		<?php echo $form->error($model,'monto_renta'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gasto_comun'); ?>
		<?php echo $form->textField($model,'gasto_comun'); ?>
		<?php echo $form->error($model,'gasto_comun'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'gasto_variable'); ?>
		<?php echo $form->textField($model,'gasto_variable'); ?>
		<?php echo $form->error($model,'gasto_variable'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'monto_mueble'); ?>
		<?php echo $form->textField($model,'monto_mueble'); ?>
		<?php echo $form->error($model,'monto_mueble'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->