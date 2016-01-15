<?php
/* @var $this ContratoController */
/* @var $data Contrato */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('folio')); ?>:</b>
	<?php echo CHtml::encode($data->folio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha_inicio')); ?>:</b>
	<?php echo CHtml::encode($data->fecha_inicio); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto_renta')); ?>:</b>
	<?php echo CHtml::encode($data->monto_renta); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto_gastocomun')); ?>:</b>
	<?php echo CHtml::encode($data->monto_gastocomun); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('plazo')); ?>:</b>
	<?php echo CHtml::encode($data->plazo); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('departamento_id')); ?>:</b>
	<?php echo CHtml::encode($data->departamento_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cliente_id')); ?>:</b>
	<?php echo CHtml::encode($data->cliente_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_contrato_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_contrato_id); ?>
	<br />

	*/ ?>

</div>