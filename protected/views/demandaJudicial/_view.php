<?php
/* @var $this DemandaJudicialController */
/* @var $data DemandaJudicial */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('rol')); ?>:</b>
	<?php echo CHtml::encode($data->rol); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('causa')); ?>:</b>
	<?php echo CHtml::encode($data->causa); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('contrato_id')); ?>:</b>
	<?php echo CHtml::encode($data->contrato_id); ?>
	<br />


</div>