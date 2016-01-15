<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs = array(
    'Contratos' => array('index'),
    'Crear',
);

$this->menu = array(
    array('label' => 'Administrar Contratos', 'url' => array('admin')),
);
?>

<h1>Crear Contrato</h1>

<?php
echo $this->renderPartial('_form', array('model' => $model,
    'ctaModel' => $ctaModel,
    'propiedades' => $propiedades,
    'clientes' => $clientes,
    'tiposContrato' => $tiposContrato));
?>