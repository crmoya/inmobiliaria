<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'demanda-judicial-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'rol'); ?>
		<?php echo $form->textField($model,'rol',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'rol'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'causa'); ?>
		<?php echo $form->textField($model,'causa',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'causa'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contrato_id'); ?>
		<?php echo $form->dropDownList($model,'contrato_id', CHtml::listData(Contrato::model()->getDeUsuario(Yii::app()->user->id), 'id', 'folio'),array('prompt'=>'Seleccione un Contrato')); ?>
		<?php echo $form->error($model,'contrato_id'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'formato_demanda_id'); ?>
		<?php echo $form->dropDownList($model,'formato_demanda_id', CHtml::listData(FormatoDemanda::model()->findAll(), 'id', 'nombre'),
                            array('prompt'=>'Seleccione un Formato de Demanda')); ?>
		<?php echo $form->error($model,'formato_demanda_id'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->