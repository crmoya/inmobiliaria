<?php
/* @var $this ContratoController */
/* @var $model Contrato */

$this->breadcrumbs = array(
    'Contratos vigentes'=>array('admin'),
    'Datos del Arrendatario Contrato #'.$model->folio,
);
?>

<h4>Datos del Arrendatario en <?php echo $model->departamento->propiedad->nombre." depto. ".$model->departamento->numero;?></h4>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model->cliente,
    'attributes' => array(
        'rut',
        array(
            'label' => 'Nombre',
            'value' => $model->cliente->usuario->nombre." ".$model->cliente->usuario->apellido
        ),
        array(
            'label' => 'Email',
            'value' => $model->cliente->usuario->email
        ),
        'direccion_alternativa',
        'telefono',
        'ocupacion',
        'renta',
    ),
));

?>
<br/>
<?php

if(count($model->cliente->clienteFiadors) > 0){
    echo "<h4>Datos del Fiador</h4>";
    $fiador = $model->cliente->clienteFiadors->fiador;
    $this->widget('zii.widgets.CDetailView', array(
        'data' => $fiador,
        'attributes' => array(
            'rut',
            array(
                'label' => 'Nombre',
                'value' => $fiador->nombre." ".$fiador->apellido
            ),
            'email',
            'telefono',
            'direccion',
        ),
    ));
}


?>
<br/>