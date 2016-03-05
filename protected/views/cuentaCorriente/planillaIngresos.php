<?php


$this->breadcrumbs=array(
	'Exportar Planilla de Ingresos por propiedad',
);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'movimiento-form',
    'enableAjaxValidation' => false,
));

?>
    <div class="span2" style="background:#EFEFEF;border-radius: 5px;padding:5px;">Propiedad</div>
    <div class="span3">
        <?php echo $form->labelEx($model, 'propiedad_id'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'propiedad_id', CHtml::listData($propiedades,'id','nombre'), array('empty' => 'Seleccione propiedad',)
        );
        ?>
        <?php echo $form->error($model, 'propiedad_id'); ?>
    </div>
    <div class="clearfix"></div>
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
    <div class="span2" style="background:#EFEFEF;border-radius: 5px;padding:5px;">Mostrar ABONOS Y CARGOS</div>
    <div class="span3">
        <?php echo $form->labelEx($model, 'abonosYCargos'); ?>
        <?php
        echo $form->checkbox($model, 'abonosYCargos');
        ?>
        <?php echo $form->error($model    , 'abonosYCargos'); ?>
    </div>
    <div class="clearfix"></div>
    <br/>
    <div class="span2">
        <?php echo CHtml::submitButton('Planilla de Ingresos',array('id'=>'estado_cuenta','class'=>'btn')); ?>
    </div>
    <br/>
<?php
$this->endWidget(); 
?>
