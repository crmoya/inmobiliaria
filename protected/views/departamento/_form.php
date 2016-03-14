<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'departamento-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="span3">
		<?php echo $form->labelEx($model,'propiedad_id'); ?>
		<?php echo $form->dropDownList(
                            $model,
                            'propiedad_id',
							Chtml::listData($propiedades,'id','nombre'),
                            array('empty'=>'Seleccione una Propiedad',)
					); 
		?>
		<?php echo $form->error($model,'propiedad_id'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'numero'); ?>
		<?php echo $form->textField($model,'numero'); ?>
		<?php echo $form->error($model,'numero'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'mt2'); ?>
		<?php echo $form->textField($model,'mt2'); ?>
		<?php echo $form->error($model,'mt2'); ?>
	</div>
<div class="clearfix"></div>
	<div class="span2">
		<?php echo $form->labelEx($model,'dormitorios'); ?>
		<?php echo $form->textField($model,'dormitorios'); ?>
		<?php echo $form->error($model,'dormitorios'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'estacionamientos'); ?>
		<?php echo $form->textField($model,'estacionamientos'); ?>
		<?php echo $form->error($model,'estacionamientos'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'renta'); ?>
		<?php echo $form->textField($model,'renta'); ?>
		<?php echo $form->error($model,'renta'); ?>
	</div>

    <div class="clearfix"></div>
	<div class="row buttons span3">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
	</div>
<br/>
<?php $this->endWidget(); ?>

</div><!-- form -->

