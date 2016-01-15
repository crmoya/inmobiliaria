<?php
/* @var $this MovimientoController */
/* @var $model Movimiento */

$this->breadcrumbs=array(
        'Selección de Cuentas Corriente' => array('indexType'),
	'Movimientos'=>array('/movimiento/viewDetail/'.$cuenta_cte),
	'Crear',
);
?>

<h1>Crear Movimiento</h1>

<?php echo $this->renderPartial('_formCreate', array('model'=>$model, 'cuenta_cte'=>$cuenta_cte, 'lista_cuentas'=>$lista_cuentas)); ?>