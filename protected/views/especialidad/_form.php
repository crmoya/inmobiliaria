<?php
/* @var $this EspecialidadController */
/* @var $model Especialidad */
/* @var $form CActiveForm */
?>

<div class="span12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'especialidad-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="span2">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
    <div class="clearfix"></div>
	<div class="span2">
		<?php echo CHtml::submitButton('Guardar',array('class'=>'btn')); ?>
	</div>
    <br/>

<?php $this->endWidget(); ?>

</div><!-- form -->