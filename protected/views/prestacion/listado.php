<?php

$this->breadcrumbs=array(
    'Prestaciones a Propiedades por fecha',
);

$form = $this->beginWidget('CActiveForm', array(
    'id' => 'movimiento-form',
    'enableAjaxValidation' => false,
));

?>
    <div class="span2" style="background:#EFEFEF;border-radius: 5px;padding:5px;">Propiedad</div>
    <div class="span4">
        <?php echo $form->labelEx($model, 'propiedad_id'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'propiedad_id', CHtml::listData($propiedades,'id','nombre'), 
                array(  'empty' => 'TODAS LAS PROPIEDADES',
                            'ajax' => array(
                                'type'=>'POST', //request type
                                'url'=>CController::createUrl('//propiedad/getDepartamentos'), 
                                'update'=>'#departamento_id', 
                            ),
                )
        );
        ?>
        <?php echo $form->error($model, 'propiedad_id'); ?>
    </div>
    <div class="clearfix"></div>
    <div class="span2" style="background:#EFEFEF;border-radius: 5px;padding:5px;">Departamento</div>
    <div class="span4">
        <?php echo $form->labelEx($model, 'departamento_id'); ?>
        <?php
        echo $form->dropDownList(
                $model, 'departamento_id', CHtml::listData(array(),'id','nombre'), array('prompt' => 'TODOS LOS DEPARTAMENTOS','id'=>'departamento_id')
        );
        ?>
        <?php echo $form->error($model, 'departamento_id'); ?>
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
    <br/>
    <div class="span2">
        <?php echo CHtml::submitButton('Listado de Prestaciones de propiedades',array('id'=>'estado_cuenta','class'=>'btn')); ?>
    </div>
    <br/>
<?php
$this->endWidget(); 
?>
