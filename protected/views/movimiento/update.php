<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */

$this->breadcrumbs=array(
        'Selección de Cuentas Corriente' => array('indexType'),
	'Movimientos'=>array('/movimiento/viewDetail/'.$cuenta_cte),
	'Actualizar',
);
?>

<h1>Actualizar Movimiento</h1>

<?php echo $this->renderPartial('_formUpdate', array('model'=>$model, 'cuenta_cte'=>$cuenta_cte, 'lista_cuentas'=>$lista_cuentas)); ?>