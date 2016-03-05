<?php
/* @var $this IpcController */
/* @var $model Ipc */
/* @var $form CActiveForm */
?>

<script>
$(document).ready(function(e){
    $('.fixed').change(function(e) {
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
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'ipc-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'porcentaje'); ?>
		<?php echo $form->textField($model,'porcentaje',array('class'=>'fixed')); ?>
		<?php echo $form->error($model,'porcentaje'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'mes'); ?>
		<?php echo $form->dropDownList($model,'mes', CHtml::listData(
                array(  array('id'=>'1','nombre'=>'ENERO'),
                        array('id'=>'2','nombre'=>'FEBRERO'),
                        array('id'=>'3','nombre'=>'MARZO'),
                        array('id'=>'4','nombre'=>'ABRIL'),
                        array('id'=>'5','nombre'=>'MAYO'),
                        array('id'=>'6','nombre'=>'JUNIO'),
                        array('id'=>'7','nombre'=>'JULIO'),
                        array('id'=>'8','nombre'=>'AGOSTO'),
                        array('id'=>'9','nombre'=>'SEPTIEMBRE'),
                        array('id'=>'10','nombre'=>'OCTUBRE'),
                        array('id'=>'11','nombre'=>'NOVIEMBRE'),
                        array('id'=>'12','nombre'=>'DICIEMBRE'),
                    ), 'id', 'nombre')); ?>
		<?php echo $form->error($model,'mes'); ?>
	</div>
        
        <div class="row">
		<?php echo $form->labelEx($model,'agno'); ?>
		<?php echo $form->textField($model,'agno'); ?>
		<?php echo $form->error($model,'agno'); ?>
	</div>
        

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->