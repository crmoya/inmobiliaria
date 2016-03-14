<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */

$this->breadcrumbs=array(
	'Propiedades',
);

if(Yii::app()->user->rol != 'propietario'){
    $this->menu=array(
        array('label'=>'Crear Propiedad', 'url'=>array('create')),
    );
}

?>
<?php 
if(Yii::app()->user->rol != 'propietario'){
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'propiedad-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array('name'=>'propietario_nom', 'value'=>'$data->propietario!=null?$data->propietario->rut:""'),
		'nombre',
		'direccion',
		'mt_construidos',
		'mt_terreno',
		'inscripcion',
		array(
			'class'=>'CButtonColumn',
		),
	),
    ));
}else{
    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'propiedad-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'nombre',
		'direccion',
		'mt_construidos',
		'mt_terreno',
		'cant_estacionamientos',
		'inscripcion',
	),
    ));
}
?>
