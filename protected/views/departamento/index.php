<?php
/* @var $this DepartamentoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Departamentos',
);

if(Yii::app()->user->rol == 'superusuario' ||
        Yii::app()->user->rol == 'administrativo'){
    $this->menu=array(
	array('label'=>'Crear Departamento', 'url'=>array('create')),
	array('label'=>'Administrar Departamentos', 'url'=>array('admin')),
);
}
?>

<h1>Departamentos</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
