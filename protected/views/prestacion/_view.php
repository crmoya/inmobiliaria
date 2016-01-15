<?php
/* @var $this PrestacionController */
/* @var $data Prestacion */
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

	<b><?php echo CHtml::encode($data->getAttributeLabel('documento')); ?>:</b>
	<?php echo CHtml::encode($data->documento); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('descripcion')); ?>:</b>
	<?php echo CHtml::encode($data->descripcion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_prestacion_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_prestacion_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('ejecutor_id')); ?>:</b>
	<?php echo CHtml::encode($data->ejecutor_id); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('genera_cargos')); ?>:</b>
	<?php echo CHtml::encode($data->genera_cargos); ?>
	<br />

	*/ ?>

</div>