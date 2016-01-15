<?php
/* @var $this ReajusteRentaController */
/* @var $model ReajusteRenta */
/* @var $form CActiveForm */
?>

<div class="form">

<script>
$(document).ready(function(e){
    $('#ReajusteRenta_porcentaje').change(function(e) {
        var text = $(this).val();
        text = text.replace(',','.');
        if(!isNaN(text)){
            var num = new Number(text);
            num = num.toFixed(1);
            $(this).val(num);
        }else{
            $(this).val(0);
        }
    });    
});
</script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reajuste-renta-form',
	'enableAjaxValidation'=>false,
)); ?>
    <?php
    $fecha_desde = "";
    if($model->isNewRecord){
        $fecha_desde = date("d/m/Y");
    }
    else{
        $fecha_desde = Tools::backFecha($model->fecha_desde);
    }
    ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_desde'); ?>
		<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecha_desde',
                    'language' => 'es',
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_fecha',
                        'size' => '10',
                        'maxlength' =>'10',
                        'value' => $fecha_desde,
                        'class' => 'fixed_2',
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
		<?php echo $form->error($model,'fecha_desde'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'porcentaje'); ?>
		<?php echo $form->textField($model,'porcentaje'); ?>
		<?php echo $form->error($model,'porcentaje'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->