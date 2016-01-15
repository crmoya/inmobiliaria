<?php
$this->breadcrumbs = array(
    'Movimientos',
);
?>
<h2>Listado de Usuarios al Día</h2>
<p>Se muestran tanto los departamentos como los usuarios a los que están asociados</p>

<div class="row"><?php echo CHtml::link('Exportar a Excel',array('pagoMes/exportarXLS','id'=>$contrato_id)); ?></div>

<table class="table table-hover table-bordered footable" data-filter="#filter" data-page-size="10">
    <thead>
        <tr>
            <th>Mes</th>
            <th>Monto Renta</th>
            <th>Gasto Común</th>
            <th>Monto Mueble</th>
            <th>Gasto Variable</th>
            <th>Contrato</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($pagos as $pago) {
            ?>
        <tr>
            <td><?php echo $pago->fecha ;?></td>
            <td><?php echo $pago->monto_renta;?></td>
            <td><?php echo $pago->gasto_comun;?></td>
            <td><?php echo $pago->monto_mueble ;?></td>
            <td><?php echo $pago->gasto_variable;?></td>
            <td><?php echo $pago->contrato->folio;?></td>
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