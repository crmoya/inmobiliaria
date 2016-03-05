<?php
/* @var $this ContratoController */
/* @var $model Contrato */
/* @var $form CActiveForm */
?>

<div class="span12">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'contrato-form',
        'enableAjaxValidation' => false,
    ));
    ?>
    <?php
        echo $form->errorSummary($model);
        if(isset($ctaModel)){
            echo $form->errorSummary($ctaModel);
        }        
    ?> 
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'folio'); ?>
        <?php echo $form->textField($model, 'folio',array('readonly'=>'readonly')); ?>
        <?php echo $form->error($model, 'folio'); ?>
    </div>

    <div class="span3">
        <?php echo $form->labelEx($model, 'fecha_inicio'); ?>
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
        <?php echo $form->error($model, 'fecha_inicio'); ?>
    </div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'monto_renta'); ?>
        <?php echo $form->textField($model, 'monto_renta'); ?>
        <?php echo $form->error($model, 'monto_renta'); ?>
    </div>

    <div class="clearfix"></div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'monto_gastocomun'); ?>
        <?php echo $form->textField($model, 'monto_gastocomun'); ?>
        <?php echo $form->error($model, 'monto_gastocomun'); ?>
    </div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'monto_mueble'); ?>
        <?php echo $form->textField($model, 'monto_mueble'); ?>
        <?php echo $form->error($model, 'monto_mueble'); ?>
    </div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'monto_gastovariable'); ?>
        <?php echo $form->textField($model, 'monto_gastovariable'); ?>
        <?php echo $form->error($model, 'monto_gastovariable'); ?>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'monto_castigado'); ?>
        <?php echo $form->textField($model, 'monto_castigado'); ?>
        <?php echo $form->error($model, 'monto_castigado'); ?>
    </div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'monto_primer_mes'); ?>
        <?php echo $form->textField($model, 'monto_primer_mes'); ?>
        <?php echo $form->error($model, 'monto_primer_mes'); ?>
    </div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'dias_primer_mes'); ?>
        <?php echo $form->textField($model, 'dias_primer_mes'); ?>
        <?php echo $form->error($model, 'dias_primer_mes'); ?>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'monto_cheque'); ?>
        <?php echo $form->textField($model, 'monto_cheque'); ?>
        <?php echo $form->error($model, 'monto_cheque'); ?>
    </div>

    <div class="span3">
        <?php echo $form->labelEx($model, 'plazo'); ?>
        <?php echo $form->textField($model, 'plazo'); ?>
        <?php echo $form->error($model, 'plazo'); ?>
    </div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'reajusta_meses'); ?>
        <?php echo $form->dropDownList($model,'reajusta_meses', CHtml::listData(
                array(  array('id'=>'6','nombre'=>'CADA 6 MESES'),
                        array('id'=>'8','nombre'=>'CADA 8 MESES'),
                        array('id'=>'12','nombre'=>'CADA 12 MESES'),
                        array('id'=>'0','nombre'=>'NO REAJUSTA'),), 'id', 'nombre'),
            array('prompt'=>'Seleccione una Opción')); ?>
        <?php echo $form->error($model, 'reajusta_meses'); ?>
    </div>
    
    <div class="clearfix"></div>
    
    <div class="span3">
        <?php echo $form->labelEx($model, 'dia_pago'); ?>
        <?php echo $form->textField($model, 'dia_pago'); ?>
        <?php echo $form->error($model, 'dia_pago'); ?>
    </div>

    <div class="span3">
        <?php echo $form->labelEx($ctaModel, 'saldo_inicial'); ?>
        <?php echo $form->textField($ctaModel, 'saldo_inicial'); ?>
        <?php echo $form->error($ctaModel, 'saldo_inicial'); ?>
    </div>
    
        <div class="span3">
            <?php echo $form->labelEx($model, 'propiedad_id'); ?>
            <?php echo $form->dropDownList($model,'propiedad_id', CHtml::listData($propiedades, 'id', 'nombre'),
                array(
                    'ajax' => array(
                        'type'=>'POST', //request type
                        'url'=>CController::createUrl('//propiedad/getDepartamentos'), 
                        'update'=>'#departamento_id', 
                    ),
                    'prompt'=>'Seleccione una Propiedad')); ?>
            <?php echo $form->error($model, 'propiedad_id'); ?>
        </div>
    
    <div class="clearfix"></div>

        <div class="span3">
            <?php echo $form->labelEx($model, 'departamento_id'); ?>
            <?php echo $form->dropDownList($model,'departamento_id',array(),
                array(
                    'prompt'=>'Seleccione un departamento',
                    'id'=>'departamento_id',
                )
            ); ?>
            <?php echo $form->error($model, 'departamento_id'); ?>
        </div>

        <div class="span3">
            <?php echo $form->labelEx($model, 'cliente_id'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'cliente_id', $clientes, array('empty' => 'Seleccione un Cliente',)
            );
            ?>
            <?php echo $form->error($model, 'cliente_id'); ?>
        </div>

        <div class="span3">
            <?php echo $form->labelEx($model, 'tipo_contrato_id'); ?>
            <?php
            echo $form->dropDownList(
                    $model, 'tipo_contrato_id', $tiposContrato, array('empty' => 'Seleccione un Tipo de Contrato',)
            );
            ?>
            <?php echo $form->error($model, 'tipo_contrato_id'); ?>
        </div>

    <div class="clearfix"></div>
<br/>
        <div class="span3 buttons">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
        </div>

        <?php $this->endWidget(); ?>
<br/>
</div><!-- form -->