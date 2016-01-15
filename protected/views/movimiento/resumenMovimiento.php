<?php
/* @var $this ResumenMovimientoFormController */
/* @var $model ResumenMovimientoForm */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'resumen-movimiento-form-resumenMovimiento-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // See class documentation of CActiveForm for details on this,
        // you need to use the performAjaxValidation()-method described there.
        'enableAjaxValidation' => false,
    ));
    ?>

        <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'inicio'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'language' => 'es',
            'attribute'=>'inicio',
            'options' => array(
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'dateFormat'=>'yy-mm-dd',
                'showButtonPanel' => true,
            ),
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>
<?php echo $form->error($model, 'inicio'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'fin'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'language' => 'es',
            'attribute'=>'fin',
            'value' => date('d/m/Y'),
            'options' => array(
                'showAnim' => 'slide', //'slide','fold','slideDown','fadeIn','blind','bounce','clip','drop'
                'dateFormat'=>'yy-mm-dd',
                'showButtonPanel' => true,
            ),
            'htmlOptions' => array(
                'style' => ''
            ),
        ));
        ?>
<?php echo $form->error($model, 'fin'); ?>
    </div>


    <div class="row buttons">
    <?php echo CHtml::submitButton('Generar'); ?>
    </div>

<?php $this->endWidget(); ?>

</div><!-- form -->