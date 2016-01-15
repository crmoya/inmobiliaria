<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs=array(
	'Contratos'=>array('admin'),
	'Firmar Contrato',
);

$this->menu=array(
	array('label'=>'Crear Contrato', 'url'=>array('create')),
	array('label'=>'Ver Contrato Firmado', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Administrar Contratos', 'url'=>array('admin')),
);
?>

<h1>Firmar el Contrato de folio: <?php echo $model->folio;?></h1>
<div class="form">

    <p class="note">
        Debe cargar la imagen con el contrato ya firmado:
    </p>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'contrato-form',
    'enableAjaxValidation' => false,
    'htmlOptions' => array('enctype' => 'multipart/form-data'),
));
?>
    <?php echo $form->errorSummary($model);?>
    <div class="row span10">
        <?php echo $form->labelEx($model, 'imagen'); ?>
        <?php echo $form->fileField($model, 'imagen'); ?>
        <?php echo $form->error($model, 'imagen'); ?>
    </div>
    
        <div class="row buttons span2">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Crear' : 'Guardar'); ?>
            <br/>
<br/>
        </div>

<?php $this->endWidget(); ?>

</div><!-- form -->
