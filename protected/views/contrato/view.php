<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs = array(
    'Contratos' => array('index'),
    $model->id,
);
if (Yii::app()->user->rol == 'superusuario' ||
        Yii::app()->user->rol == 'administrativo') {
    $this->menu = array(
        array('label' => 'Crear Contrato', 'url' => array('create')),
        array('label' => 'Borrar Contrato', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => '¿Está seguro de borrar este item?')),
        array('label' => 'Administrar Contratos', 'url' => array('admin')),
    );
}
?>

<h1>Contrato #<?php echo $model->id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'id',
        'folio',
        'fecha_inicio',
        'monto_renta',
        'monto_gastocomun',
        'plazo',
        array(
            'label' => 'Nombre Propiedad',
            'value' => $model->departamento->propiedad->nombre
        ),
        array(
            'label' => 'Numero Departamento',
            'value' => $model->departamento->numero
        ),
        array(
            'label' => 'Rut Cliente',
            'value' => $model->cliente->rut
        ),
        array(
            'label' => 'Tipo de Contrato',
            'value' => $model->tipoContrato->nombre
        ),
    ),
));
?>
