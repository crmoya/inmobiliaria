<?php
/* @var $this EgresoController */
/* @var $model Egreso */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'egreso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
    
	<?php echo $form->errorSummary($model); ?>

	<div class="span2">
		<?php echo $form->labelEx($model,'fecha'); ?>
		<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecha',
                    'language' => 'es',
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_fecha',
                        'size' => '10',
                        'maxlength' =>'10',
                        'readonly'=> 'readonly',
                    ),
                    'defaultOptions' => array(  // (#3)
                        'showOn' => 'focus', 
                        'dateFormat' => 'dd/mm/yy',
                        'showOtherMonths' => true,
                        'selectOtherMonths' => true,
                        'changeMonth' => true,
                        'changeYear' => true,
                        'showButtonPanel' => true,
                      )
                ));
                ?>
		<?php echo $form->error($model,'fecha'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'monto'); ?>
		<?php echo $form->textField($model,'monto'); ?>
		<?php echo $form->error($model,'monto'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'concepto'); 
                    $this->widget('zii.widgets.jui.CJuiAutoComplete',array(
                        'model'=>$model,
                        'attribute'=>'concepto',
                        'source'=>  $conceptos,
                        // additional javascript options for the autocomplete plugin
                        'options'=>array(
                            'minLength'=>'1',
                        ),
                        'htmlOptions'=>array(
                            'style'=>'height:20px;',
                        ),
                    ));
                    echo $form->error($model,'concepto'); ?>
	</div>

	<div class="span2">
            <?php echo $form->labelEx($model,'respaldo'); ?>
            <?php echo $form->checkbox($model,'respaldo'); ?>
	</div>

    <div class="clearfix"></div>
	<div class="span2">
		<?php echo $form->labelEx($model,'cta_contable'); ?>
		<?php echo $form->textField($model,'cta_contable',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'cta_contable'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'nro_cheque'); ?>
		<?php echo $form->textField($model,'nro_cheque',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nro_cheque'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'proveedor'); ?>
		<?php echo $form->textField($model,'proveedor',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'proveedor'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'nro_documento'); ?>
		<?php echo $form->textField($model,'nro_documento',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'nro_documento'); ?>
	</div>
<div class="clearfix"></div>
        <div class="span3">
		<?php echo $form->labelEx($model,'centro_costo_id'); ?>
		<?php echo $form->dropDownList(
                    $model,
                    'centro_costo_id',
                    CHtml::listData(CentroCosto::model()->findAll(), 'id', 'nombre'),
                    array('prompt'=>'Seleccione Centro de Costo',)
                ); 
		?>
		<?php echo $form->error($model,'centro_costo_id'); ?>
	</div>

        <div class="span3" id="div_propiedad">
		<?php echo $form->labelEx($model,'propiedad_id'); ?>
		<?php echo $form->dropDownList(
                    $model,
                    'propiedad_id',
                    CHtml::listData(Propiedad::model()->getDeUsuario(Yii::app()->user->id), 'id', 'nombre'),
                    array(  
                        'prompt'=>'Seleccione Propiedad',
                        'id'=>'propiedad_id',
                        'ajax' => array(
                            'type'=>'POST', 
                            'url'=>CController::createUrl('//propiedad/getDepartamentos'), 
                            'update'=>'#departamento_id', 
                        ),
                    )
                ); 
		?>
		<?php echo $form->error($model,'propiedad_id'); ?>
	</div>

        <div class="span3" id="div_departamento">
            <?php echo $form->labelEx($model, 'departamento_id'); ?>
            <?php echo $form->dropDownList($model,'departamento_id',array(),
                array(
                    'prompt'=>'Seleccione un departamento',
                    'id'=>'departamento_id',
                )
            ); ?>
            <?php echo $form->error($model, 'departamento_id'); ?>
	</div>

    <div class="clearfix"></div>

        <div class="row buttons span3">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
	</div>
    <br>

<?php $this->endWidget(); ?>

</div><!-- form -->
<script>
$(document).ready(function(e){
    $('#div_propiedad').hide();
    $('#div_departamento').hide();
});
</script>