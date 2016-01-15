<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propiedad-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'propietario_id'); ?>
		<?php echo $form->dropDownList(
                            $model,
                            'propietario_id',
                            CHtml::listData(Propietario::model()->findAll(),'id','nombreRut'),
                            array('empty'=>'Seleccione un Propietario',)
					); 
		?>
		<?php echo $form->error($model,'propietario_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mt_construidos'); ?>
		<?php echo $form->textField($model,'mt_construidos'); ?>
		<?php echo $form->error($model,'mt_construidos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'mt_terreno'); ?>
		<?php echo $form->textField($model,'mt_terreno'); ?>
		<?php echo $form->error($model,'mt_terreno'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'cant_estacionamientos'); ?>
		<?php echo $form->textField($model,'cant_estacionamientos'); ?>
		<?php echo $form->error($model,'cant_estacionamientos'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'inscripcion'); ?>
		<?php echo $form->textField($model,'inscripcion',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'inscripcion'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->