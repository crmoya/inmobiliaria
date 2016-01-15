<?php
/* @var $this ContratoMuebleController */
/* @var $model ContratoMueble */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'contrato-mueble-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'folio_contrato_asociado'); ?>
		<?php echo $form->dropDownList($model,'contrato_id', CHtml::listData(Contrato::model()->findAll(), 'id', 'folio'),
                array(
                    'prompt'=>'Seleccione un Contrato')); ?>
		<?php echo $form->error($model,'contrato_id'); ?>
	</div>
    
        <div class="row">
                <?php echo $form->labelEx($model,'imagen'); ?>
                <?php echo $form->fileField($model,'imagen'); ?> 
                <?php echo $form->error($model,'imagen'); ?>
        </div>	
    
        <div class="row">
		<?php echo $form->labelEx($model,'fecha_inicio'); ?>
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
                            'readonly'=>'readonly',
                        ),
                    )
		);
		?>
		<?php echo $form->error($model,'fecha_inicio'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto'); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->