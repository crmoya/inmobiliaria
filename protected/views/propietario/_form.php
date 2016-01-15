<?php
/* @var $this PropietarioController */
/* @var $model Propietario */
/* @var $form CActiveForm */
?>

<div class="form">
    
    <?php
        $readonly = "_nothing";
        $btn = "btn_propietario";
        if(!$model->isNewRecord){
            $readonly = "readonly";
            $btn = "";
        }
    ?>
    
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/script.js"> </script>
    <script>
    $(document).ready(function(e){
        $('.btn_propietario').click(function(e){
            
            $('.error_rutpropietario').html("");
            var rut = replaceAll($("#Propietario_rut").val(),".","");
            $('.error_email').html("");
            var email = $("#Propietario_email").val();
            
            $.ajax({
                type: "POST",
                url: '<?php echo CController::createUrl('//usuario/checkRut');?>',
                data: { rut: rut }
            }).done(function( msg ) {
                if(msg == 'false'){
                    $('.error_rutpropietario').html("Ya existe un usuario con ese RUT");
                    return false;
                }
                else{
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
                            $('#propietario-form').submit();
                        }
                    });
                }
            });
            e.preventDefault();
        });
    });
    </script>

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propietario-form',
	'enableAjaxValidation'=>false,
)); ?>

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
	<div class="row">
		<?php echo $form->labelEx($model,'rut'); ?>
		<?php echo $form->textField($model,'rut',array('size'=>11,'maxlength'=>11,$readonly=>$readonly)); ?>
		<?php echo $form->error($model,'rut'); ?><div class="error_rutpropietario"></div>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'nombre'); ?>
		<?php echo $form->textField($model,'nombre',array('size'=>60,'maxlength'=>100,'value'=>$nombre)); ?>
		<?php echo $form->error($model,'nombre'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'apellido'); ?>
		<?php echo $form->textField($model,'apellido',array('size'=>60,'maxlength'=>100,'value'=>$apellido)); ?>
		<?php echo $form->error($model,'apellido'); ?>
	</div>
    
        <div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>100,'value'=>$email)); ?>
		<?php echo $form->error($model,'email'); ?><div class="error_email"></div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'direccion'); ?>
		<?php echo $form->textField($model,'direccion',array('size'=>60,'maxlength'=>200)); ?>
		<?php echo $form->error($model,'direccion'); ?>
	</div>
    
        <?php
        if($model->isNewRecord):?>
        <div class="row">
            <?php echo $form->labelEx($model,'clave'); ?>
            <p class="note">Su clave serán los dígitos de su rut sin dígito verificador. Por favor cámbiela cuanto antes.</p>
            <?php echo $form->error($model,'clave'); ?>
	</div>
        <?php
        endif;
        ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar',array('class'=>$btn)); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->