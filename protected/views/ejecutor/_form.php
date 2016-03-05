<?php
/* @var $this EjecutorController */
/* @var $model Ejecutor */
/* @var $form CActiveForm */
?>

<div class="span12">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ejecutor-form',
	'enableAjaxValidation'=>false,
)); ?>
	<?php echo $form->errorSummary($model); ?>

	<div class="span2">
		<?php echo $form->labelEx($model,'rut'); ?>
		<?php echo $form->textField($model,'rut',array('size'=>11,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'rut'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>

    <div class="clearfix"></div>
	<div class="span2">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'especialidad_id'); ?>
		<?php echo $form->dropDownList($model,'especialidad_id',
                        CHtml::listData(Especialidad::model()->findAll(),'id','nombre'),
                        array('prompt'=>'Seleccione Especialidad')); ?>
		<?php echo $form->error($model,'especialidad_id'); ?>
	</div>
        
<div class="clearfix"></div>
<br/>
	<div class="span2">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
	</div>
<br/>

<?php $this->endWidget(); ?>

</div><!-- form -->