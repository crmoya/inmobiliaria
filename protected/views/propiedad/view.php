<?php
/* @var $this PropiedadController */
/* @var $model Propiedad */

$this->breadcrumbs=array(
	'Propiedades'=>array('admin'),
	'Propiedad #'.$model->id,
);

if (Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo') {
    $this->menu = array(
        array('label' => 'Crear Propiedad', 'url' => array('create')),
        array('label' => 'Actualizar Propiedad', 'url' => array('update', 'id' => $model->id)),
        array('label' => 'Borrar Propiedad', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => '¿Está seguro de borrar este elemento?')),
        array('label' => 'Administrar Propiedades', 'url' => array('admin')),
    );
}
?>
<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array('value'=>$model->propietario->nombreRut,'name'=>'rut'),
        'nombre',
        'direccion',
        'mt_construidos',
        'mt_terreno',
        'cant_estacionamientos',
        'inscripcion',
    ),
));
?>
