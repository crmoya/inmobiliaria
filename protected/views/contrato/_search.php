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
		<?php echo $form->label($model,'monto_renta'); ?>
		<?php echo $form->textField($model,'monto_renta'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'monto_gastocomun'); ?>
		<?php echo $form->textField($model,'monto_gastocomun'); ?>
	</div>

        <div class="row">
		<?php echo $form->label($model,'monto_castigado'); ?>
		<?php echo $form->textField($model,'monto_castigado'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'monto_primer_mes'); ?>
		<?php echo $form->textField($model,'monto_primer_mes'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'dias_primer_mes'); ?>
		<?php echo $form->textField($model,'dias_primer_mes'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'monto_cheque'); ?>
		<?php echo $form->textField($model,'monto_cheque'); ?>
	</div>
    
	<div class="row">
		<?php echo $form->label($model,'plazo'); ?>
		<?php echo $form->textField($model,'plazo'); ?>
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

	<div class="row">
		<?php echo $form->label($model,'tipo_nombre'); ?>
		<?php echo $form->textField($model,'tipo_nombre'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Buscar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->