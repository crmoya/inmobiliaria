<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */

$this->breadcrumbs=array(
        'Contratos vigentes'=>array('//contrato/adminAbonos'),
        'Movimientos'=>array('/movimiento/viewDetail/'.$model->cuenta_corriente_id),
	'Actualizar',
);
?>


<?php echo $this->renderPartial('_formUpdate', array('model'=>$model, )); ?>