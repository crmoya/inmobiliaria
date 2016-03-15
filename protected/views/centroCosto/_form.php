<?php
/* @var $this CentroCostoController */
/* @var $model CentroCosto */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'centro-costo-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>100,'maxlength'=>100,'style'=>'width:300px !important;')); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'carga_a'); ?>
		<?php echo $form->dropDownList($model,'carga_a',CHtml::listData(array(
                            array('id'=>'1','nombre'=>'Propiedad'),
                            array('id'=>'2','nombre'=>'Departamento'),
                            array('id'=>'3','nombre'=>'Inmobiliaria'),
                        ),'id','nombre')
                    ); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->