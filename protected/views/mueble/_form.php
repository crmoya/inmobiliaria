<?php
/* @var $this MuebleController */
/* @var $model Mueble */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mueble-form',
	'enableAjaxValidation'=>false,
)); ?>
    
    <?php
    $fecha = "";
    if($model->isNewRecord){
        $fecha = date("d/m/Y");
    }
    else{
        $fecha = Tools::backFecha($model->fecha_compra);
    }
    ?>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'fecha_compra'); ?>
		<?php
                $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                    'model' => $model,
                    'attribute' => 'fecha_compra',
                    'language' => 'es',
                    'htmlOptions' => array(
                        'id' => 'datepicker_for_fecha',
                        'size' => '10',
                        'maxlength' =>'10',
                        'value' => $fecha,
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
		<?php echo $form->error($model,'fecha_compra'); ?>
	</div>
    
        <div class="row">
            <?php echo $form->labelEx($model, 'propiedad_id'); ?>
            <?php echo $form->dropDownList($model,'propiedad_id', CHtml::listData(Propiedad::model()->getDeUsuario(Yii::app()->user->id), 'id', 'nombre'),
                array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('//propiedad/getDepartamentosAll'), 
                        'update'=>'#departamento_id', 
                    ),
                    'prompt'=>'Seleccione una Propiedad')); ?>
            <?php echo $form->error($model, 'propiedad_id'); ?>
        </div>
        <div class="row">
            <?php echo $form->labelEx($model, 'departamento_id'); ?>
            <?php if($model->isNewRecord): ?>
            <?php echo $form->dropDownList($model,'departamento_id',array(),
                array(
                    'prompt'=>'Seleccione un departamento',
                    'id'=>'departamento_id',
                )
            ); ?>
            <?php else: ?>
            <?php echo $form->dropDownList($model,'departamento_id',  CHtml::listData(Departamento::model()->findAllByAttributes(array('propiedad_id'=>$model->propiedad_id)), 'id', 'numero'),
                array(
                    'prompt'=>'Seleccione un departamento',
                    'id'=>'departamento_id',
                )
            ); ?>
            <?php endif; ?>
            <?php echo $form->error($model, 'departamento_id'); ?>
        </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
