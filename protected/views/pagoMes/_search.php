<?php
/* @var $this PagoMesController */
/* @var $model PagoMes */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'contrato_id'); ?>
		<?php echo $form->textField($model,'contrato_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monto_renta'); ?>
		<?php echo $form->textField($model,'monto_renta'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gasto_comun'); ?>
		<?php echo $form->textField($model,'gasto_comun'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'gasto_variable'); ?>
		<?php echo $form->textField($model,'gasto_variable'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monto_mueble'); ?>
		<?php echo $form->textField($model,'monto_mueble'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php echo $form->textField($model,'fecha'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Search'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->