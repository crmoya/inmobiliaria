<?php
/* @var $this PropiedadController */
/* @var $data Propiedad */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('propietario.rut')); ?>:</b>
	<?php echo CHtml::encode($data->propietario->rut); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('direccion')); ?>:</b>
	<?php echo CHtml::encode($data->direccion); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mt_construidos')); ?>:</b>
	<?php echo CHtml::encode($data->mt_construidos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mt_terreno')); ?>:</b>
	<?php echo CHtml::encode($data->mt_terreno); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('cant_estacionamientos')); ?>:</b>
	<?php echo CHtml::encode($data->cant_estacionamientos); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('inscripcion')); ?>:</b>
	<?php echo CHtml::encode($data->inscripcion); ?>
	<br />

	*/ ?>

</div>