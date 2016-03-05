<?php
/* @var $this CuentaCorrienteController */
/* @var $model CuentaCorriente */

$this->breadcrumbs=array(
	'Clientes Morosos',
);

?>
<div class="span6">
    <div class="span2">
        
    </div>
    
    
</div>
<div class="span2"><?php echo CHtml::link("Exportar ".CHtml::image(Yii::app()->baseUrl."/images/excel.png"),CController::createUrl("/cuentaCorriente/exportarXLS"),array('class'=>'')); ?></div>
<div class="clearfix"></div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cuenta-corriente-grid',
	'dataProvider'=>$model->search(),
        'filter'=>$model,
	'columns'=>array(
            'propiedad',
            'departamento',
            array('name'=>'nombre_ap','value'=>'$data->nombre." ".$data->apellido'),
            'monto',
            array('name'=>'fecha','value'=>'Tools::backFecha($data->fecha)'),
            'dias',
            array(
                'class'=>'CButtonColumn',
                'template'=>'{view}',
                'header'=>'Movimientos',
                'buttons'=>array(
                    'view'=>array(
                        'label'=>'Ver movimientos de esta cuenta',
                        'imageUrl'=>Yii::app()->baseUrl.'/images/lista.png',
                        'url'=>'Yii::app()->createUrl("//movimiento/viewDetail/", array("id"=>$data->cuenta_corriente_id))',
                    ),
                ),
            ),
	),
)); ?>
