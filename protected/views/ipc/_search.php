<?php
/* @var $this IpcController */
/* @var $model Ipc */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'porcentaje'); ?>
		<?php echo $form->textField($model,'porcentaje'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'mes'); ?>
		<?php 
			echo $form->dropDownList(
				$model,
				'mes',
				CHtml::listData(array(
                                        array('id'=>'1','nombre'=>'ENERO'),
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
                                    ), 'id', 'nombre'),
				array('prompt'=>'Seleccione un Mes',)
			);
		?>
	</div>
    
        <div class="row">
		<?php echo $form->label($model,'agno'); ?>
		<?php echo $form->textField($model,'agno'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Filtrar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->