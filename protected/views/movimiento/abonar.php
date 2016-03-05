<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */
/* @var $form CActiveForm */
?>

<?php
$this->breadcrumbs=array(
	'Movimientos de la cuenta #'.$model->cuenta_corriente_id=>array('//movimiento/viewDetail/'.$model->cuenta_corriente_id),
	'Abonar la cuenta #'.$model->cuenta_corriente_id,
);
?>
<fieldset class="form">
    <legend>Abonar la Cuenta Corriente: <?php echo $model->cuentaCorriente->nombre; ?></legend>
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

<div class="span12">

   <?php
   $form = $this->beginWidget('CActiveForm', array(
       'id' => 'movimiento-form',
       'enableAjaxValidation' => false,
   ));
   ?>
      <?php echo $form->errorSummary($model); ?>

   <div class="span2">
      <?php echo $form->labelEx($model, 'fecha'); ?>
      <?php
      $this->widget('zii.widgets.jui.CJuiDatePicker', array(
          'model' => $model,
          'attribute' => 'fecha',
          'language' => 'es',
          'options' => array(
              'dateFormat' => 'yy-mm-dd',
          ),
          'htmlOptions' => array(
              'size' => '10', // textField size
              'maxlength' => '10', // textField maxlength
              'readonly'=>'readonly',
              'id'=>'fecha',
          ),
      ));
      ?>
      <?php echo $form->error($model, 'fecha'); ?>
   </div>


    
   
    
    
<div class="span2">
      <?php echo $form->labelEx($model, 'detalle'); ?>
      <?php echo $form->textField($model, 'detalle', array('size' => 100, 'maxlength' => 200,'style'=>'width:180px !important;','id'=>'detalle')); ?>
<?php echo $form->error($model, 'detalle'); ?>
   </div>

    <div class="span2">
      <?php echo $form->labelEx($model, 'monto'); ?>
      <?php echo $form->textField($model, 'monto',array('class'=>'fixed','id'=>'monto')); ?>
<?php echo $form->error($model, 'monto'); ?>
   </div>

    <div class="span3">
      <?php echo $form->labelEx($model, 'forma_pago_id'); ?>
      <?php echo $form->dropDownList($model, 'forma_pago_id', 
                        CHtml::listData(FormaPago::model()->findAll(),'id','nombre'),array('empty'=>'Selecione Forma Pago','id'=>'formaPago')); ?>
      <?php echo $form->error($model, 'forma_pago_id'); ?>
   </div>
    
    <div class="span2">
        <br/>
        <?php echo CHtml::link('Agregar Concepto','#',array('class'=>'btn','id'=>'agregar')); ?>
    </div>
    
</fieldset>
<hr/>
<table class="table">
    <thead>
        <tr><th>Concepto</th><th>Monto</th><th>Forma de Pago</th><th>Eliminar </th></tr>
    </thead>
    <tbody id="abonos">
    </tbody>
</table>
<hr/>
   <?php $this->endWidget(); ?>

<div class="span2">
    <?php echo CHtml::link('Volver',array("//movimiento/viewDetail/".$model->cuenta_corriente_id),array('class'=>'btn')); ?>
</div>
<div class="span2">
    <?php echo CHtml::link('Imprimir '.CHtml::image(Yii::app()->baseUrl.'/images/printer.png'),'#',array('class'=>'btn','id'=>'print')); ?>
</div>
<div class="span2">
    <?php echo CHtml::link('Enviar por Email '.CHtml::image(Yii::app()->baseUrl.'/images/sobre.png'),'#',array('class'=>'btn','id'=>'mail')); ?>
</div>
<div class="clearfix"></div>
<br/>
<table id="cupon">
    <tr>
        <td colspan="2"><h3>Recibo de Pagos</h3></td>
    </tr>
    <tr>
        <td colspan="2"><p>Junto con saludarle, Inmobiliaria SUR le informa que se han recibido correctamente los siguientes pagos a su cuenta corriente</p></td>
    </tr>
    <tr>
        <td class="td">Cuenta Corriente: <?php echo $model->cuentaCorriente->nombre;?></td>
        <td class="td"><div id="fechaPago"></div></td>
    </tr>
    <tr>
        <td class="td">RUT Cliente: <?php echo $model->cuentaCorriente->contrato->cliente->rut;?></td>
        <td class="td">Nombre Cliente: <?php echo $model->cuentaCorriente->contrato->cliente->usuario->nombre." ".$model->cuentaCorriente->contrato->cliente->usuario->apellido;?></td>
    </tr>
    <tr>
        <td class="td">Propiedad: <?php echo $model->cuentaCorriente->contrato->departamento->propiedad->nombre;?></td>
        <td class="td">Departamento: <?php echo $model->cuentaCorriente->contrato->departamento->numero;?></td>
    </tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td colspan="2"><table id="pagos"></table></td>
    </tr>
    <tr><td>&nbsp;</td><td>&nbsp;</td></tr>
    <tr>
        <td colspan="2">Cordialmente, nos despedimos.</td>
    </tr>
</table>

<script>
$(document).ready(function(e){
    $('#fecha').change(function(e){
        $('#fechaPago').html('Fecha: '+backFecha($(this).val()));
    });
    $('#fechaPago').html('Fecha: '+backFecha($('#fecha').val()));
    function format(nStr) {
        nStr += '';
        var x = nStr.split(',');
        var x1 = x[0];
        var x2 = x.length > 1 ? ',' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
                x1 = x1.replace(rgx, '$1' + '.' + '$2');
        }
        return x1 + x2;
    }
    var formas = Array();
    <?php 
    $formas = FormaPago::model()->findAll();
    foreach($formas as $forma){
        echo 'formas['.$forma->id.']="'.$forma->nombre.'";';
    }
    ?>
    function formatPago(formaPago){
        return formas[formaPago];
    }
    function backFecha(fecha){
        var fechaArr = fecha.split('-');
        if(fechaArr.length == 3){
            return fechaArr[2]+"/"+fechaArr[1]+"/"+fechaArr[0];
        }
    }
    $('#mail').click(function(e){
        $('#pagos').empty();
        $('#pagos').append('<thead><th>Concepto</th><th>Monto</th><th>Forma Pago</th></thead><tbody>');
        var total = 0;
        $('#abonos').children().each(function(e){
            var i = 0;
            var tr = '<tr>';
            $(this).children().each(function(e){
                if(i<3){
                    if(i == 1){
                        total+=parseInt($(this).html());
                    }
                    tr+= '<td class="tdLight">'+$(this).html()+'</td>';
                    i++;
                }
                else{
                    i = 0;
                }
            });
            tr += '</tr>';
            $('#pagos').append(tr); 
        });
        $('#pagos').append('<tr><td><b>Total</b></td><td colspan="2">'+total+'</td></tr></tbody>');
        $.ajax({
            type: "POST",
            url: '<?php echo CController::createUrl('//cuentaCorriente/send');?>',
            data: { body:$('#cupon').html(),cuenta:'<?php echo $model->cuenta_corriente_id;?>'}
        }).done(function( msg ) {
            swal(msg);
        });
    });
    $('#print').click(function(e){
        $('#pagos').empty();
        $('#pagos').append('<thead><th>Concepto</th><th>Monto</th><th>Forma Pago</th></thead><tbody>');
        var total = 0;
        $('#abonos').children().each(function(e){
            var i = 0;
            var tr = '<tr>';
            $(this).children().each(function(e){
                if(i<3){
                    if(i == 1){
                        total+=parseInt($(this).html());
                    }
                    tr+= '<td class="tdLight">'+$(this).html()+'</td>';
                    i++;
                }
                else{
                    i = 0;
                }
            });
            tr += '</tr>';
            $('#pagos').append(tr); 
        });
        $('#pagos').append('<tr><td><b>Total</b></td><td colspan="2">'+total+'</td></tr></tbody>');
        window.print();
    });
    $('#agregar').click(function(e){
        e.preventDefault();
        var detalle = $('#detalle').val();
        var formaPago = $('#formaPago').val();
        var monto = $('#monto').val();
        if(detalle.trim() == ''){
            swal('ERROR: Debe agregar un detalle para el concepto del abono.');
        }
        else{
            var fecha = $('#fecha').val();
            $.ajax({
                type: "POST",
                url: '<?php echo CController::createUrl('//movimiento/create');?>',
                data: { formaPago:formaPago, cuenta:<?php echo $model->cuenta_corriente_id?>, fecha:fecha,monto: monto, detalle: detalle, tipo: '<?php echo Tools::MOVIMIENTO_TIPO_ABONO;?>'}
            }).done(function( msg ) {
                var id = msg;
                if(id > 0){
                    var abono = "<tr id='mov"+id+"'><td>"+detalle+"</td><td>"+format(monto)+"</td><td>"+formatPago(formaPago)+"</td><td><img class='delete' src='<?php echo Yii::app()->baseUrl.'/images/eliminar.png';?>' mov='"+id+"'/></td></tr>";
                    $('#abonos').append(abono);
                }
                else{
                    swal('Error: No se pudo agregar el movimiento. Revise que no haya sido agregado previamente.');
                }
                $('#detalle').val('');
                $('#monto').val('0');
                $('#formaPago').prop('selectedIndex', 0);
            });
        }
    });
    
    $(document.body).on('click','.delete',function(ev){
        var mov = $(this).attr('mov');
        $.ajax({
            type: "POST",
            url: '<?php echo CController::createUrl('//movimiento/eliminar');?>',
            data: { mov:mov}
        }).done(function( msg ) {
            if(msg == 'OK'){
                $("#mov"+mov).remove();
            }
            else{
                swal(msg);
            }
        });
        
    });
    
    
    $('.fixed').change(function(e) {
        var text = $(this).val();
        text = text.replace(',','.');
        if(!isNaN(text)){
            var num = new Number(text);
            num = num.toFixed(0);
            $(this).val(num);
        }else{
            $(this).val(0);
        }
    });
});
</script>
<style>
    .borde{
        border:1px solid #EFEFEF;
    }
    .delete:hover{
        cursor:pointer;
    }
    @media screen{
        #cupon{
            visibility: hidden;
        }
    }
    @media print{
        body{
            visibility: hidden;
        }
        #cupon{
            margin:0 auto;
            position:absolute;
            top:10px;
            visibility: visible;
        }
        .td{
            border:1px solid black;
        }
        .tdLight{
            border:1px solid silver;
        }
    }
</style>