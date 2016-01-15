

<?php
$this->breadcrumbs = array(
    'Cuentas por contrato',
);
?>
<h2>Selección de Cuentas</h2>
<p>Determine la cuenta corriente a seleccionar por el folio del contrato</p>

<table class="table table-hover table-bordered footable" data-filter="#filter" data-page-size="10">
    <thead>
        <tr>
            <th>Folio Contrato</th>
            <th>Nombre Cliente</th>
            <th>Rut</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($cuentas as $cuenta) {
            ?>
        <tr>
            <td><?php echo CHtml::link($cuenta->contrato->folio, array('movimiento/viewDetail/' . $cuenta->id));?></td>
            <td><?php echo $cuenta->contrato->cliente->usuario->nombre." ".$cuenta->contrato->cliente->usuario->apellido;?></td>
            <td><?php echo $cuenta->contrato->cliente->rut;?></td>
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


