<?php
/* @var $this CuentaCorrienteController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Cuentas Corriente',
);

$this->menu=array(
	(Yii::app()->user->rol == 'propietario' || Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo')?array('label'=>'Crear Cuenta Corriente', 'url'=>array('create')):array(),
	array('label'=>'Administrar Cuentas Corriente', 'url'=>array('admin')),
);
?>

<h1>Cuentas Corriente</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
