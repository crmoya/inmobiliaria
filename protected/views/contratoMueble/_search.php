<?php
/* @var $this ContratoController */
/* @var $model Contrato */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'folio'); ?>
		<?php echo $form->textField($model,'folio'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_inicio'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'model'=>$model,
                        'language' => 'es',
                        'attribute'=>'fecha_inicio',
                        // additional javascript options for the date picker plugin
                        'options'=>array(
                                'showAnim'=>'fold',
                                'dateFormat'=>'dd/mm/yy',
                                'changeYear'=>true,
                                'changeMonth'=>true,
                        ),
                        'htmlOptions'=>array(
                        'style'=>'width:70px;',	
                        ),
                    )
		);
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monto'); ?>
		<?php echo $form->textField($model,'monto'); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model,'propiedad_nombre'); ?>
		<?php echo $form->textField($model,'propiedad_nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'depto_nombre'); ?>
		<?php echo $form->textField($model,'depto_nombre'); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model,'cliente_rut'); ?>
		<?php echo $form->textField($model,'cliente_rut'); ?>
	</div>
	<div class="row">
		<?php echo $form->label($model,'cliente_nombre'); ?>
		<?php echo $form->textField($model,'cliente_nombre'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->