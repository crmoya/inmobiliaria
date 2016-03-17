<?php
/* @var $this EgresoController */
/* @var $model Egreso */
/* @var $form CActiveForm */
?>

<div class="form">
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
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'egreso-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>
    
	
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
                    array('prompt'=>'Seleccione Centro de Costo','id'=>'centro_costo')
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
                            'url'=>CController::createUrl('//propiedad/getDepartamentosAll'), 
                            'update'=>'#departamento_id', 
                        ),
                    )
                ); 
		?>
		<?php echo $form->error($model,'propiedad_id'); ?>
	</div>
        <div class="clearfix"></div>
        <br/>
        <div class="span12" id="div_departamento">
            <span><big>¿A qué departamentos se aplica el egreso?</big></span>
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
    
    var arrToggle = Array();
    <?php
    $centros = CentroCosto::model()->findAll();
    foreach($centros as $centro){
        echo "arrToggle[".$centro->id."]='".$centro->carga_a."';";
    }
    ?>
    togglePropDep();
    function togglePropDep(){
        var valor = $('#centro_costo').val();
        if(arrToggle[valor] == '1'){
            $('#div_propiedad').show();
            $('#div_departamento').hide();
        }
        else if(arrToggle[valor] == '2'){
            $('#div_propiedad').hide();
            $('#div_departamento').show();
        }
        else if(arrToggle[valor] == '3'){
            $('#div_propiedad').hide();
            $('#div_departamento').hide();
        }
        else{
            $('#div_propiedad').hide();
            $('#div_departamento').hide();
        }
    }
    $('#centro_costo').change(function(e){
        togglePropDep();
    });
    
    
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
    $egresos_deptos = EgresoDepartamento::model()->findAllByAttributes(array('egreso_id'=>$model->id));
    $l = 0;
    foreach($egresos_deptos as $egDep){
        $depto_id = $egDep->departamento_id;
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