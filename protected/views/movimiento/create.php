<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */

$this->breadcrumbs=array(
        'Contratos vigentes'=>array('//contrato/adminAbonos'),
        'Movimientos'=>array('/movimiento/viewDetail/'.$cuenta_cte),
	'Crear',
);
?>

<?php echo $this->renderPartial('_formCreate', array('model'=>$model, 'cuenta_cte'=>$cuenta_cte, 'lista_cuentas'=>$lista_cuentas)); ?>