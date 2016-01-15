<?php
$this->breadcrumbs = array(
    'Movimientos',
);
?>
<p>Determine la cuenta corriente a seleccionar por el Propietario y nombre de usuario</p>

<table class="table table-hover table-bordered footable" data-filter="#filter" data-page-size="10">
    <thead>
        <tr>
            <th>Nombre Cliente</th>
            <th>Rut</th>
            <th>Nombre Cuenta</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if(Yii::app()->user->rol == 'propietario'):
        foreach ($cuentas_propietario as $cuenta) {
            
            ?>
        <tr>
            <td><?php echo $cuenta->contrato->cliente->usuario->nombre;?></td>
            <td><?php echo $cuenta->contrato->cliente->rut;?></td>
            <td><?php echo CHtml::link($cuenta->nombre, array('movimiento/viewDetail/'.$cuenta->id));?></td>
        </tr>
        <?php
        
        }
        endif;
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

<div class="row"><?php echo CHtml::link('Vea los clientes al día',array('movimiento/clientesDia')); ?></div>
<div class="row"><?php echo CHtml::link('Vea los clientes morosos',array('movimiento/clientesMorosos')); ?></div>