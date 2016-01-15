<?php
/* @var $this CuentaCorrienteController */
/* @var $data CuentaCorriente */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />
	
	<b><?php echo CHtml::encode($data->getAttributeLabel('saldo_inicial')); ?>:</b>
	<?php echo CHtml::encode($data->saldo_inicial); ?>
	<br />


</div>