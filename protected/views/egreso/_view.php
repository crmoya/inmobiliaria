<?php
/* @var $this EgresoController */
/* @var $data Egreso */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('fecha')); ?>:</b>
	<?php echo CHtml::encode($data->fecha); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('monto')); ?>:</b>
	<?php echo CHtml::encode($data->monto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('concepto')); ?>:</b>
	<?php echo CHtml::encode($data->concepto); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('respaldo')); ?>:</b>
	<?php echo CHtml::encode($data->respaldo); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cta_contable')); ?>:</b>
	<?php echo CHtml::encode($data->cta_contable); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_cheque')); ?>:</b>
	<?php echo CHtml::encode($data->nro_cheque); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('egresocol')); ?>:</b>
	<?php echo CHtml::encode($data->egresocol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('centro_costo_id')); ?>:</b>
	<?php echo CHtml::encode($data->centro_costo_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('proveedor')); ?>:</b>
	<?php echo CHtml::encode($data->proveedor); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nro_documento')); ?>:</b>
	<?php echo CHtml::encode($data->nro_documento); ?>
	<br />

	*/ ?>

</div>