<h1>Tipo de Cuenta Corriente <?php echo Yii::app()->user->rol; ?></h1>

<?php
$this->breadcrumbs = array(
    'Movimientos',
);
?>
<div class="row">
   <?php
   echo CHtml::link('Cuentas de Propietarios', array('movimiento/indexPerson'));
   ?>
</div>
<div class="row">
   <?php
   echo CHtml::link('Cuentas de Clientes', array('movimiento/indexContract'));
   ?>
</div>
<div class="row">
   <?php
   echo CHtml::link('Resumen de movimientos', array('movimiento/resumenMovimiento'));
   ?>
</div>

