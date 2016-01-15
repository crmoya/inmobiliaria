<?php
/* @var $this ContratoMuebleController */
/* @var $data ContratoMueble */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contrato_id')); ?>:</b>
	<?php echo CHtml::encode($data->contrato_id); ?>
	<br />


</div>