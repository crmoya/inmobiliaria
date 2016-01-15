<?php
/* @var $this PrestacionController */
/* @var $model Prestacion */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'fecha'); ?>
		<?php
		$this->widget('zii.widgets.jui.CJuiDatePicker',
                    array(
                        'model'=>$model,
                        'language' => 'es',
                        'attribute'=>'fecha',
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
		<?php echo $form->label($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'tipo_prestacion_id'); ?>
		<?php 
                    echo $form->dropDownList(
                            $model,
                            'tipo_prestacion_id',
                            CHtml::listData(TipoPrestacion::model()->findAll(), 'id', 'nombre'),
                            array('prompt'=>'Seleccione un Tipo de Prestación',)
                    );
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'ejecutor_id'); ?>
		<?php 
                    echo $form->dropDownList(
                            $model,
                            'ejecutor_id',
                            CHtml::listData(Ejecutor::model()->findAll(), 'id', 'nombre'),
                            array('prompt'=>'Seleccione un Ejecutor',)
                    );
		?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'genera_cargos'); ?>
		<?php 
                    echo $form->dropDownList(
                            $model,
                            'genera_cargos',
                            CHtml::listData(array(array('id'=>'Sí','nombre'=>'Sí'),array('id'=>'No','nombre'=>'No')), 'id', 'nombre'),
                            array('prompt'=>'Todos',)
                    );
		?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Filtrar'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->