<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs = array(
    'Nuevo Contrato',
);

$this->menu = array(
    array('label' => 'Administrar Contratos', 'url' => array('admin')),
);
?>

<?php
echo $this->renderPartial('_form', array('model' => $model,
    'ctaModel' => $ctaModel,
    'propiedades' => $propiedades,
    'clientes' => $clientes,
    'tiposContrato' => $tiposContrato));
?>