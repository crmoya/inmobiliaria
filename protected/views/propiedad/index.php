<?php
/* @var $this PropiedadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Propiedades',
);
if(Yii::app()->user->rol == 'superusuario' ||
        Yii::app()->user->rol == 'administrativo'){
    $this->menu=array(
	array('label'=>'Crear Propiedad', 'url'=>array('create')),
	array('label'=>'Administrar Propiedades', 'url'=>array('admin')),
);
}

?>

<h1>Propiedades</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
