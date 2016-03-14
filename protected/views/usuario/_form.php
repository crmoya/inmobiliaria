<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'usuario-form',
	'enableAjaxValidation'=>false,
)); ?>

        <?php
        $readonly = "_nothing";
        if(!$model->isNewRecord){
            $readonly = "readonly";
        }
        ?>
    
	<?php echo $form->errorSummary($model); ?>
        
	<div class="row">
		<?php echo $form->labelEx($model,'user'); ?>
		<?php echo $form->textField($model,'user',array('size'=>60,'maxlength'=>200,$readonly=>$readonly)); ?>
		<?php echo $form->error($model,'user'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'apellido'); ?>
		<?php echo $form->textField($model,'apellido',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'apellido'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'rol'); ?>
		<?php 
                    echo $form->dropDownList(
                            $model,
                            'rol',
                            CHtml::listData(array(array('id'=>'superusuario'),array('id'=>'administrativo')), 'id', 'id'),
                            array('prompt'=>'Seleccione un Rol',)
                    );
		?>
		<?php echo $form->error($model,'rol'); ?>
	</div>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->