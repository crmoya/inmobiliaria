<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs = array(
    'Contratos a Reajustar dentro de un mes'=>array('adminAReajustar'),
    'Datos del Arrendatario Contrato #'.$model->folio,
);
?>

<h4>Montos actuales en <?php echo $model->departamento->propiedad->nombre." depto. ".$model->departamento->numero;?></h4>

<?php
$cliente = $model->cliente->usuario->nombre." ".$model->cliente->usuario->apellido;
$rut = $model->cliente->rut;
$simulacion = $model->getSimulacionReajuste();
$actual = $simulacion['actual'];
$nuevo = $simulacion['nuevo'];

$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Cliente',
            'value' => $cliente,
        ),
        array(
            'label' => 'RUT',
            'value' => $rut,
        ),
        array(
            'label' => 'Renta',
            'value' => '$ '.number_format($actual->monto_renta,0,',','.')
        ),
        array(
            'label' => 'Gasto Común',
            'value' => '$ '.number_format($actual->monto_gastocomun,0,',','.')
        ),
        array(
            'label' => 'Gasto Variable',
            'value' => '$ '.number_format($actual->monto_gastovariable,0,',','.')
        ),
        array(
            'label' => 'Mueble',
            'value' => '$ '.number_format($actual->monto_mueble,0,',','.')
        ),
        array(
            'label' => 'Rige desde',
            'value' => $actual->agno."-".str_pad($actual->mes, 2,"0",STR_PAD_LEFT)."-".str_pad($actual->dia, 2,"0",STR_PAD_LEFT)
        ),
    ),
));

?>
<br/>
<h4>Montos futuros</h4>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        array(
            'label' => 'Renta',
            'value' => '$ '.number_format($nuevo->monto_renta,0,',','.')
        ),
        array(
            'label' => 'Gasto Común',
            'value' => '$ '.number_format($nuevo->monto_gastocomun,0,',','.')
        ),
        array(
            'label' => 'Gasto Variable',
            'value' => '$ '.number_format($nuevo->monto_gastovariable,0,',','.')
        ),
        array(
            'label' => 'Mueble',
            'value' => '$ '.number_format($nuevo->monto_mueble,0,',','.')
        ),
        array(
            'label' => 'Rige desde',
            'value' => date('m')==12?$nuevo->agno+1:$nuevo->agno."-".str_pad(date('m')%12+1, 2,"0",STR_PAD_LEFT)."-".str_pad($nuevo->dia, 2,"0",STR_PAD_LEFT)
        ),
    ),
));

?>
<br/>
