<?php
/* @var $this TipoContratoController */
/* @var $model TipoContrato */
/* @var $form CActiveForm */


?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'tipo-contrato-form',
	'enableAjaxValidation'=>false,
        'htmlOptions' => array('enctype' => 'multipart/form-data'),
)); ?>
        <div class="span3">
            <?php echo $form->errorSummary($model); ?>

            <div class="row">
                    <?php echo $form->labelEx($model,'nombre'); ?>
                    <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100)); ?>
                    <?php echo $form->error($model,'nombre'); ?>
            </div>

            <div class="row">
                    <?php echo $form->labelEx($model,'documento'); ?>
                    <?php echo $form->fileField($model,'documento'); ?> 
                    <?php echo $form->error($model,'documento'); ?>
            </div>	

            <div class="row buttons">
                    <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn')); ?>
            </div>
        </div>
        <div class="span5">
            <div class="note">Los siguientes campos están disponibles para agregar al nuevo Tipo de Contrato desde la Base de Datos</div>
            <br/>
            <table class="tabla_campos">
                <thead>
                    <tr>
                        <th>CAMPO</th>
                        <th>DESCRIPCIÓN</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>#CONTRATO_FOLIO#</td>
                        <td>FOLIO DEL CONTRATO</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_FECHA_INICIO#</td>
                        <td>FECHA DE INICIO DEL CONTRATO</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_MONTO_RENTA#</td>
                        <td>MONTO DE LA RENTA ESTIPULADA POR CONTRATO</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_MONTO_PRIMER_MES#</td>
                        <td>MONTO CANCELADO EL PRIMER MES</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_DIAS_PRIMER_MES#</td>
                        <td>DÍAS PROPORCIONALES DEL PRIMER MES</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_MONTO_CHEQUE#</td>
                        <td>MONTO CANCELADO CON CHEQUE EL PRIMER MES</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_MONTO_GASTO_COMUN#</td>
                        <td>GASTOS COMUNES</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_MONTO_CASTIGADO#</td>
                        <td>MONTO CASTIGO POR NO PAGO EN FECHA</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_MONTO_MUEBLE#</td>
                        <td>GASTOS POR MUEBLES</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_MONTO_GASTO_VARIABLE#</td>
                        <td>GASTOS VARIABLES</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_REAJUSTA_MESES#</td>
                        <td>PLAZO EN EL QUE REAJUSTA</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_DIA_PAGO#</td>
                        <td>DÍA DE PAGO</td>
                    </tr>
                    <tr>
                        <td>#CONTRATO_PLAZO#</td>
                        <td>PLAZO DEL CONTRATO</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_RUT#</td>
                        <td>RUT DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_NOMBRE#</td>
                        <td>NOMBRE DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_APELLIDO#</td>
                        <td>APELLIDO DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_EMAIL#</td>
                        <td>EMAIL DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_DIRECCION#</td>
                        <td>DIRECCIÓN ALTERNATIVA DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_TELEFONO#</td>
                        <td>TELÉFONO DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_OCUPACION#</td>
                        <td>OCUPACIÓN DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#CLIENTE_RENTA#</td>
                        <td>RENTA DEL CLIENTE</td>
                    </tr>
                    <tr>
                        <td>#PROPIEDAD_NOMBRE#</td>
                        <td>NOMBRE DE LA PROPIEDAD</td>
                    </tr>
                    <tr>
                        <td>#PROPIEDAD_DIRECCION#</td>
                        <td>DIRECCIÓN DE LA PROPIEDAD</td>
                    </tr>
                    <tr>
                        <td>#DEPARTAMENTO_NUMERO#</td>
                        <td>NÚMERO DEL DEPARTAMENTO</td>
                    </tr>
                    <tr>
                        <td>#DEPARTAMENTO_MT2#</td>
                        <td>METROS CUADRADOS DEL DEPARTAMENTO</td>
                    </tr>
                    <tr>
                        <td>#DEPARTAMENTO_DORMITORIOS#</td>
                        <td>CANTIDAD DE DORMITORIOS DEL DEPARTAMENTO</td>
                    </tr>
                    <tr>
                        <td>#DEPARTAMENTO_ESTACIONAMIENTOS#</td>
                        <td>CANTIDAD DE ESTACIONAMIENTOS DEL DEPARTAMENTO</td>
                    </tr>     
                    <tr>
                        <td>#DEPARTAMENTO_RENTA#</td>
                        <td>RENTA SUGERIDA PARA EL DEPARTAMENTO</td>
                    </tr>
                </tbody>
            </table>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->