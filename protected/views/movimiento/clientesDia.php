<?php
$this->breadcrumbs = array(
    'Movimientos',
);
?>
<h2>Listado de Usuarios al Día</h2>
<p>Se muestran tanto los departamentos como los usuarios a los que están asociados</p>

<table class="table table-hover table-bordered footable" data-filter="#filter" data-page-size="10">
    <thead>
        <tr>
            <th>Departamento</th>
            <th>Rut Cliente</th>
            <th>Nombre Cliente</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($departamentos as $depto) {
            ?>
        <tr>
            <td><?php echo "Edificio ". $depto->propiedad->nombre. " Nº " .$depto->numero ;?></td>
            <td><?php echo $depto->contrato->cliente->rut;?></td>
            <td><?php echo $depto->contrato->cliente->usuario->nombre;?></td>
            <td><?php echo CHtml::link('Ver detalle pagos',array('pagoMes/verDetalle',
                                         'id'=>$depto->contrato->id)); ?></td>
        </tr>
        <?php
        
    }
    ?>
</tbody>
<tfoot class="hide-if-no-paging">
    <tr>
        <td colspan="5">
            <div class="pagination pagination-centered"></div>
        </td>
    </tr>
</tfoot>
</table>
<script type="text/javascript">
    $(function() {
        $('.footable').footable();
    });
</script>