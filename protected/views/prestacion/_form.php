<?php
/* @var $this PrestacionController */
/* @var $model Prestacion */
/* @var $form CActiveForm */


$this->breadcrumbs=array(
    'Nueva Prestación',
);

?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, // use transitions?
    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
      ),)
); ?>
<script>
$(document).ready(function(e){
    window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
});
</script> 
<script>
$(document).ready(function(e){
    
    function contains(array,x){
        for(i=0;i<array.length;i++){
            if(array[i]==x){
                return true;
            }
        }
        return false;
    }
    
    var saved_departamentos = Array();
    <?php 
    $prestaciones_deptos = PrestacionADepartamento::model()->findAllByAttributes(array('prestacion_id'=>$model->id));
    $l = 0;
    foreach($prestaciones_deptos as $prestacion){
        $depto_id = $prestacion->departamento_id;
        echo "saved_departamentos[$l]=$depto_id;";
        $l++;
    }
    ?>		

    $(".select-on-check").each(function(e){
        if(contains(saved_departamentos,$(this).val())){
            $(this).attr('checked',true);
        }
    });
});
</script>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'prestacion-form',
	'enableAjaxValidation'=>false,
)); ?>
    <div class="span12">
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
                        'value' => date("d/m/Y"),
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
		<?php echo $form->labelEx($model,'documento'); ?>
		<?php echo $form->textField($model,'documento',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'documento'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'descripcion'); ?>
		<?php echo $form->textField($model,'descripcion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'descripcion'); ?>
	</div>

	<div class="span3">
		<?php echo $form->labelEx($model,'tipo_prestacion_id'); ?>
		<?php echo $form->dropDownList(
                    $model,
                    'tipo_prestacion_id',
                    CHtml::listData(TipoPrestacion::model()->findAll(), 'id', 'nombre'),
                    array('prompt'=>'Seleccione Tipo de Prestación',)
                ); 
		?>
		<?php echo $form->error($model,'tipo_prestacion_id'); ?>
	</div>

        
        <div class="clearfix"></div>
	<div class="span4">
		<?php echo $form->labelEx($model,'ejecutor_id'); ?>
		<?php echo $form->dropDownList(
                    $model,
                    'ejecutor_id',
                    CHtml::listData(Ejecutor::model()->listar(), 'id', 'nombre'),
                    array('prompt'=>'Seleccione Maestro',)
                ); 
		?>
		<?php echo $form->error($model,'ejecutor_id'); ?>
	</div>

	<div class="span2">
            <?php echo $form->labelEx($model,'genera_cargos'); ?>
            <?php echo $form->checkbox($model,'genera_cargos'); ?>
	</div>
        
        <div class="span2">
            <?php echo $form->labelEx($model,'general_prop'); ?>
            <?php echo $form->checkbox($model,'general_prop'); ?>
	</div>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="span12">
        <span><big>¿En qué departamentos va a ejecutar la Prestación?</big></span>
            <?php
            $this->widget('ext.selgridview.SelGridView', array(
                'id' => 'departamentos-grid',
                'filter'=>$departamentos,
                'dataProvider' => $departamentos->searchChb(),
                'selectableRows' => 2,
                'columns'=>array(
                    array(
                            'class' => 'CCheckBoxColumn',
                            'checked' => '$data["id"]',
                            'checkBoxHtmlOptions' => array(
                            'name' => 'chbDepartamentoId[]',
                        ),
                    'value'=>'$data->id',
                    ),
                    array('name'=>'propiedad_nombre','value'=>'$data->propiedad->nombre'),
                    'numero',
                    'mt2',
                    'dormitorios',
                    'estacionamientos',
                    'renta',
                 ),
              ));
            ?>
        <span class="note">Solo los departamentos que estén seleccionados quedarán asociados a la prestación.</span>
        
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="span2">
            <?php echo CHtml::submitButton('Guardar',array('class'=>'btn')); ?>
    </div>
<br/>
<?php $this->endWidget(); ?>

</div><!-- form -->