<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'propiedad_nombre'); ?>
		<?php echo $form->textField($model,'propiedad_nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'numero'); ?>
		<?php echo $form->textField($model,'numero'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mt2'); ?>
		<?php echo $form->textField($model,'mt2'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'dormitorios'); ?>
		<?php echo $form->textField($model,'dormitorios'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'estacionamientos'); ?>
		<?php echo $form->textField($model,'estacionamientos'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'renta'); ?>
		<?php echo $form->textField($model,'renta'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->