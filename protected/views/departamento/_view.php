<?php
/* @var $this DepartamentoController */
/* @var $data Departamento */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('propiedad.nombre')); ?>:</b>
	<?php echo CHtml::encode($data->propiedad->nombre); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('numero')); ?>:</b>
	<?php echo CHtml::encode($data->numero); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mt2')); ?>:</b>
	<?php echo CHtml::encode($data->mt2); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('dormitorios')); ?>:</b>
	<?php echo CHtml::encode($data->dormitorios); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estacionamientos')); ?>:</b>
	<?php echo CHtml::encode($data->estacionamientos); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('renta')); ?>:</b>
	<?php echo CHtml::encode($data->renta); ?>
	<br />


</div>