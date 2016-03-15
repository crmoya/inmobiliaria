<p>Por favor ingrese su nombre de usuario, su nueva clave será enviada a su e-mail:</p>

<?php if(Yii::app()->user->hasFlash('profileMessage')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('profileMessage'); ?>
</div>

<?php endif; ?>

<div class="span10">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableClientValidation'=>true,
	'clientOptions'=>array(
		'validateOnSubmit'=>true,
	),
)); ?>

        <div class="span2">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->textField($model,'user'); ?>
		<?php echo $form->error($model,'user'); ?>
	</div>
        <div class="clearfix"></div>
	<div class="row buttons span2">
		<?php echo CHtml::submitButton('Enviar Clave',array('class'=>'btn')); ?>
	</div>
        <br/><br/>

<?php $this->endWidget(); 
?>

</div><!-- form -->
