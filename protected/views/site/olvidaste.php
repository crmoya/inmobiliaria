<p>Por favor ingrese su nombre de usuario, su nueva clave será enviada a su e-mail:</p>

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

        <div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->textField($model,'user'); ?>
		<?php echo $form->error($model,'user'); ?>
	</div>
        
	<div class="row buttons">
		<?php echo CHtml::submitButton('Enviar Clave'); ?>
	</div>

<?php $this->endWidget(); 
?>

</div><!-- form -->
