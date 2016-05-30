<?php
/* @var $this ClienteController */
/* @var $model Cliente */
/* @var $form CActiveForm */
?>
<div class="form">
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"> </script>
    <script>
    $(document).ready(function(e){
        
        $('.btn_cliente').click(function(e){
            
            $('.error_rutcliente').html("");
            $('.error_email').html("");
            var rut = replaceAll($("#Cliente_rut").val(),".","");
            var email = $("#Cliente_email").val();
            
            
            $.ajax({
                type: "POST",
                url: '<?php echo CController::createUrl('//usuario/checkRut');?>',
                data: { rut: rut }
            }).done(function( msg ) {
                if(msg == 'false'){
                    $('.error_rutcliente').html("Ya existe un usuario con ese RUT");
                    return false;
                }
                else{
                    /*
                    $.ajax({
                        type: "POST",
                        url: '<?php echo CController::createUrl('//usuario/checkEmail');?>',
                        data: { email: email }
                    }).done(function( msg ) {
                        if(msg == 'false'){
                            $('.error_email').html("Ya existe un usuario con ese E-mail");
                            return false;
                        }
                        else{
                            $('#cliente-form').submit();
                        }
                    });
                    */
                    $('#cliente-form').submit();
                }
            });
            e.preventDefault();
        });
        
    });
    </script>

    <?php
        $readonly = "_nothing";
        $btn = "btn_cliente";
        if(!$model->isNewRecord){
            $readonly = "readonly";
            $btn = "";
        }
    ?>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cliente-form',
	'enableAjaxValidation'=>false,
)); ?>

    <div class="span12">
	<?php echo $form->errorSummary($model); ?>
        <?php
        $nombre = "";
        $apellido = "";
        $email = "";
        if(!$model->isNewRecord){
            $nombre = $model->usuario->nombre;
            $apellido = $model->usuario->apellido;
            $email = $model->usuario->email;
        }
        if(isset($_POST['Cliente']['nombre']) && isset($_POST['Cliente']['apellido']) && isset($_POST['Cliente']['email'])){
            $nombre = $_POST['Cliente']['nombre'];
            $apellido = $_POST['Cliente']['apellido'];
            $email = $_POST['Cliente']['email'];
        }
        ?>
        
        <div class="span2">
            <?php echo $form->labelEx($model,'rut'); ?>
            <?php echo $form->textField($model,'rut',array('size'=>11,'maxlength'=>11,$readonly=>$readonly)); ?>
            <?php echo $form->error($model,'rut'); ?><div class="error_rutcliente"></div>
	</div>
        
        <div class="span2">
             <?php echo $form->labelEx($model,'nombre'); ?>
             <?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100,'value'=>$nombre)); ?>
             <?php echo $form->error($model,'nombre'); ?>
	</div>
        
        <div class="span2">
            <?php echo $form->labelEx($model,'apellido'); ?>
            <?php echo $form->textField($model,'apellido',array('size'=>60,'maxlength'=>100,'value'=>$apellido)); ?>
            <?php echo $form->error($model,'apellido'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'direccion_alternativa'); ?>
		<?php echo $form->textField($model,'direccion_alternativa',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'direccion_alternativa'); ?>
	</div>

        <div class="clearfix"></div>
	<div class="span2">
		<?php echo $form->labelEx($model,'telefono'); ?>
		<?php echo $form->textField($model,'telefono',array('size'=>20,'maxlength'=>20)); ?>
		<?php echo $form->error($model,'telefono'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100,'value'=>$email)); ?>
		<?php echo $form->error($model,'email'); ?><div class="error_email"></div>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'ocupacion'); ?>
		<?php echo $form->textField($model,'ocupacion',array('size'=>60,'maxlength'=>100)); ?>
		<?php echo $form->error($model,'ocupacion'); ?>
	</div>

	<div class="span2">
		<?php echo $form->labelEx($model,'renta'); ?>
		<?php echo $form->textField($model,'renta'); ?>
		<?php echo $form->error($model,'renta'); ?>
	</div>
    
        <div class="clearfix"></div>
        <?php
        if($model->isNewRecord):?>
        <div class="span7">
            <?php echo $form->labelEx($model,'clave'); ?>
            <p class="note">Su clave serán los dígitos de su rut sin dígito verificador. Por favor cámbiela cuanto antes.</p>
            <?php echo $form->error($model,'clave'); ?>
	</div>
        <div class="clearfix"></div>
        <?php
        endif;
        ?>
    
    
   <?php 
   $fiador_rut = "";
   $fiador_nombre = "";
   $fiador_apellido = "";
   $fiador_email = "";
   $fiador_telefono = "";
   $fiador_direccion = "";
   
   $cliente_fiador = ClienteFiador::model()->findByAttributes(array('cliente_id'=>$model->id));
   if($cliente_fiador != null){
       $fiador = Fiador::model()->findByAttributes(array('id'=>$cliente_fiador->fiador_id));
       if($fiador != null){
           $fiador_rut = $fiador->rut;
           $fiador_nombre = $fiador->nombre;
           $fiador_apellido = $fiador->apellido;
           $fiador_email = $fiador->email;
           $fiador_telefono = $fiador->telefono;
           $fiador_direccion = $fiador->direccion;
       }
   }
   
   
   ?>
        <br/>
    <fieldset>
        <legend>Opcionalmente puede agregar un Fiador a este cliente</legend>
        <div class="span2">
            <?php echo $form->labelEx($model,'fiador_rut'); ?>
            <?php echo $form->textField($model,'fiador_rut',array('value'=>$fiador_rut)); ?>
            <?php echo $form->error($model,'fiador_rut'); ?><div class="error_rutfiador"></div>
	</div>
        
        <div class="span2">
            <?php echo $form->labelEx($model,'fiador_nombre'); ?>
            <?php echo $form->textField($model,'fiador_nombre',array('value'=>$fiador_nombre)); ?>
            <?php echo $form->error($model,'fiador_nombre'); ?>
	</div>
        
        <div class="span2">
            <?php echo $form->labelEx($model,'fiador_apellido'); ?>
            <?php echo $form->textField($model,'fiador_apellido',array('value'=>$fiador_apellido)); ?>
            <?php echo $form->error($model,'fiador_apellido'); ?>
	</div>
        
        <div class="span2">
            <?php echo $form->labelEx($model,'fiador_email'); ?>
            <?php echo $form->textField($model,'fiador_email',array('value'=>$fiador_email)); ?>
            <?php echo $form->error($model,'fiador_email'); ?>
	</div>
        
        <div class="clearfix"></div>
        <div class="span2">
            <?php echo $form->labelEx($model,'fiador_telefono'); ?>
            <?php echo $form->textField($model,'fiador_telefono',array('value'=>$fiador_telefono)); ?>
            <?php echo $form->error($model,'fiador_telefono'); ?>
	</div>
        
        <div class="span2">
            <?php echo $form->labelEx($model,'fiador_direccion'); ?>
            <?php echo $form->textField($model,'fiador_direccion',array('value'=>$fiador_direccion)); ?>
            <?php echo $form->error($model,'fiador_direccion'); ?>
	</div>
    </fieldset>
        <br/>
        <div class="clearfix"></div>
	<div class="span2 buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>'btn btn-default')); ?>
	</div>
        <br/><br/>

<?php $this->endWidget(); ?>

</div><!-- form -->
</div>