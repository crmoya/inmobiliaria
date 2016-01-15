<?php
/* @var $this DepartamentoController */
/* @var $model Departamento */

$this->breadcrumbs = array(
    'Departamentos' => array('admin'),
    $model->id,
);
if (Yii::app()->user->rol == 'superusuario' ||
        Yii::app()->user->rol == 'administrativo') {
    $this->menu = array(
        array('label' => 'Crear Departamento', 'url' => array('create')),
        array('label' => 'Actualizar Departamento', 'url' => array('update', 'id' => $model->id)),
        array('label' => 'Borrar Departamento', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => '¿Está seguro de borrar este elemento?')),
        array('label' => 'Administrar Departamentos', 'url' => array('admin')),
    );
}
?>

<h1>Departamento #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        array('name' => 'propiedad', 'value' => $model->propiedad->nombre),
        'numero',
        'mt2',
        'dormitorios',
        'estacionamientos',
        'renta',
    ),
));
?>
