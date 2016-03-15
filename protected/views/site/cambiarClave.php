<p>Por favor ingrese sus datos para el cambio de clave:</p>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>

<?php endif; ?>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>
    <div class="span10">
	<div class="span2">
		<?php echo $form->labelEx($model,'clave'); ?>
		<?php echo $form->passwordField($model,'clave'); ?>
		<?php echo $form->error($model,'clave'); ?>
	</div>
        <div class="clearfix"></div>
	<div class="span2">
		<?php echo $form->labelEx($model,'nueva'); ?>
		<?php echo $form->passwordField($model,'nueva'); ?>
		<?php echo $form->error($model,'nueva'); ?>
	</div>
	<div class="clearfix"></div>
	<div class="span2">
		<?php echo $form->labelEx($model,'repita'); ?>
		<?php echo $form->passwordField($model,'repita'); ?>
		<?php echo $form->error($model,'repita'); ?>
	</div>
        <div class="clearfix"></div>

	<div class="row buttons span2">
		<?php echo CHtml::submitButton('Cambiar Clave',array('class'=>'btn')); ?>
	</div>
        <br/><br/>
    </div>
<?php $this->endWidget(); 
?>

</div><!-- form -->
