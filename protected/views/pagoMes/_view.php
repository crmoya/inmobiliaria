<?php
/* @var $this PagoMesController */
/* @var $data PagoMes */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contrato_id')); ?>:</b>
	<?php echo CHtml::encode($data->contrato_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto_renta')); ?>:</b>
	<?php echo CHtml::encode($data->monto_renta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gasto_comun')); ?>:</b>
	<?php echo CHtml::encode($data->gasto_comun); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('gasto_variable')); ?>:</b>
	<?php echo CHtml::encode($data->gasto_variable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto_mueble')); ?>:</b>
	<?php echo CHtml::encode($data->monto_mueble); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />


</div>