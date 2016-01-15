<?php
/* @var $this IpcController */
/* @var $data Ipc */
?>

<div class="view">


	<b><?php echo CHtml::encode($data->getAttributeLabel('porcentaje')); ?>:</b>
	<?php echo CHtml::encode($data->porcentaje); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('mes')); ?>:</b>
	<?php echo CHtml::encode(Tools::backMes($data->mes)); ?>
	<br />

        <b><?php echo CHtml::encode($data->getAttributeLabel('agno')); ?>:</b>
	<?php echo CHtml::encode($data->agno); ?>
	<br />


</div>