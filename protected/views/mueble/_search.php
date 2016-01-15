<?php
/* @var $this MuebleController */
/* @var $model Mueble */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'fecha_compra'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'model'=>$model,
                        'language' => 'es',
                        'attribute'=>'fecha_compra',
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
		<?php echo $form->label($model,'departamento_num'); ?>
		<?php echo $form->textField($model,'departamento_num'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'propiedad_nom'); ?>
		<?php echo $form->textField($model,'propiedad_nom'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Filtrar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->