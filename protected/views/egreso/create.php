<?php
/* @var $this EgresoController */
/* @var $model Egreso */

$this->breadcrumbs=array(
	'Nuevo Egreso',
);
?>
<div class="span12">

<?php $this->renderPartial('_form', array('model'=>$model,'conceptos'=>$conceptos)); ?>
</div>