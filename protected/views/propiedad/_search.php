<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'propietario_nom'); ?>
		<?php echo $form->textField($model,'propietario_nom'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mt_construidos'); ?>
		<?php echo $form->textField($model,'mt_construidos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mt_terreno'); ?>
		<?php echo $form->textField($model,'mt_terreno'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'cant_estacionamientos'); ?>
		<?php echo $form->textField($model,'cant_estacionamientos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'inscripcion'); ?>
		<?php echo $form->textField($model,'inscripcion',array('size'=>20,'maxlength'=>20)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->