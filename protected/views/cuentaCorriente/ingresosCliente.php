<?php

$this->breadcrumbs=array(
    'Ingresos de cliente por fecha',
);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'movimiento-form',
    'enableAjaxValidation' => false,
));

?>
    <div class="span2" style="background:#EFEFEF;border-radius: 5px;padding:5px;">Fecha Desde</div>
    <div class="span3">
        <?php echo $form->labelEx($model, 'mesD'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'mesD', CHtml::listData($meses,'id','nombre'), array('empty' => 'Seleccione mes',)
        );
        ?>
        <?php echo $form->error($model, 'mesD'); ?>
    </div>
    <div class="span3">
        <?php echo $form->labelEx($model, 'agnoD'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'agnoD', CHtml::listData($agnos,'id','nombre'), array('empty' => 'Seleccione año',)
        );
        ?>
        <?php echo $form->error($model    , 'agno'); ?>
    </div>
    <div class="clearfix"></div>
    <div class="span2" style="background:#EFEFEF;border-radius: 5px;padding:5px;">Fecha Hasta</div>
    <div class="span3">
        <?php echo $form->labelEx($model, 'mesH'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'mesH', CHtml::listData($meses,'id','nombre'), array('empty' => 'Seleccione mes',)
        );
        ?>
        <?php echo $form->error($model, 'mesH'); ?>
    </div>
    <div class="span3">
        <?php echo $form->labelEx($model, 'agnoH'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'agnoH', CHtml::listData($agnos,'id','nombre'), array('empty' => 'Seleccione año',)
        );
        ?>
        <?php echo $form->error($model    , 'agnoH'); ?>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="span2">
        <?php echo CHtml::submitButton('Ingresos de Clientes por fecha',array('id'=>'estado_cuenta','class'=>'btn')); ?>
    </div>
    <br/>
<?php
$this->endWidget(); 
?>
