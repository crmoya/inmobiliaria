<?php
/* @var $this CuentaCorrienteController */
/* @var $model CuentaCorriente */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cuenta-corriente-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Campos con <span class="required">*</span> son obligatorios.</p>

	<?php 
        if($propModel!=null)echo $form->errorSummary(array($propModel));        
        if($model!=null)echo $form->errorSummary(array($model)); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'saldo_inicial'); ?>
		<?php echo $form->textField($model,'saldo_inicial'); ?>
		<?php echo $form->error($model,'saldo_inicial'); ?>
	</div>
	
	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre'); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
<?php if(Yii::app()->user->rol == 'superusuario' && $propModel!=null){ ?>
	<div class="row">
		<?php echo $form->labelEx($propModel,'propietario_id'); ?>
		<?php echo $form->dropDownList(
                            $propModel,
                            'propietario_id',
							$propietarios,
                            array('empty'=>'Seleccione un Propietario',)
					); 
		?>
		<?php echo $form->error($propModel,'propietario_id'); ?>
	</div>
<?php }?>
	
	
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->