<?php
/* @var $this ClienteController */
/* @var $model Cliente */

$this->menu=array(
	array('label'=>'Administrar Cliente', 'url'=>array('admin')),
);
?>


<p>Seleccione la Carta de Aviso que quiere enviar a <?php echo $cliente->usuario->nombre." ".$cliente->usuario->apellido;;?></p>
