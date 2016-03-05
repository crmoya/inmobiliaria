<?php
/* @var $this EspecialidadController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Especialidades',
);

$this->menu=array(
	array('label'=>'Crear Especialidad', 'url'=>array('create')),
	array('label'=>'Listar Especialidades', 'url'=>array('admin')),
);
?>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
