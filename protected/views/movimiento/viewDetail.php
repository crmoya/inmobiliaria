
<h4>Cta. Cte: <?php echo $cuenta->nombre; ?></h4>
<p>Detalle de los movimientos asociados la Cuenta Corriente</p>
<p><strong>Saldo Inicial: </strong><?php echo $cuenta->saldo_inicial; ?></p>
<table class="table table-hover table-bordered footable" data-filter="#filter" data-page-size="10">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Detalle</th>
            <th>Cuenta</th>
            <th>Abono</th>
            <th>Cargo</th>
            <th>Saldo</th>
            <th>Validado</th>
            <?php echo (Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo') ? '<th>Acciones</th>' : '<th></th>'; ?>
        </tr>
    </thead>
    <tbody>
        <?php
        $add_image = CHtml::image(Yii::app()->baseUrl . '/images/add.jpg');
        $remove_image = CHtml::image(Yii::app()->baseUrl . '/images/eliminar.png');
        $edit_image = CHtml::image(Yii::app()->baseUrl . '/images/edit.png');
        $validate_image = CHtml::image(Yii::app()->baseUrl . '/images/validated.png');
        $not_validate_image = CHtml::image(Yii::app()->baseUrl . '/images/not_validated.png');
        $saldo = $cuenta->saldo_inicial;
        foreach ($model as $mov) {
            if ($mov->tipo == Tools::MOVIMIENTO_TIPO_ABONO && $mov->validado == 1) {
                $saldo += $mov->monto;
            }
            if ($mov->tipo == Tools::MOVIMIENTO_TIPO_CARGO)
                $saldo -= $mov->monto;
            ?>
            <tr>
                <td><?php echo $mov->fecha; ?></td>
                <td><?php echo $mov->detalle; ?></td>
                <td><?php echo $mov->cuentaCorriente->nombre; ?></td>
                <td><?php echo ($mov->tipo == Tools::MOVIMIENTO_TIPO_ABONO) ? number_format($mov->monto,0,',','.') : ''; ?></td>
                <td><?php echo ($mov->tipo == Tools::MOVIMIENTO_TIPO_CARGO) ? number_format($mov->monto,0,',','.') : ''; ?></td>
                <td><?php echo number_format($saldo,0,',','.'); ?></td>
                <td><?php
                    if ((Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo' || Yii::app()->user->rol == 'propietario') && $mov->tipo == Tools::MOVIMIENTO_TIPO_ABONO) {
                        echo ($mov->validado) ?
                                CHtml::link($validate_image, 'movimiento/validate', array(
                                    'submit' => array('movimiento/validate'),
                                    'params' => array('mov_id' => $mov->id, 'cuenta_id' => $cuenta->id))) :
                                CHtml::link($not_validate_image, 'movimiento/validate', array(
                                    'submit' => array('movimiento/validate'),
                                    'params' => array('mov_id' => $mov->id, 'cuenta_id' => $cuenta->id)));
                    } else {
                        echo ($mov->validado) ? $validate_image : $not_validate_image;
                    }
                    ?>
                </td>
                <td>
                    <?php
                    echo (Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo') ?
                            CHtml::link($edit_image, 'movimiento/update', array(
                                'submit' => array('movimiento/update'),
                                'params' => array('mov_id' => $mov->id, 'cuenta_id' => $cuenta->id))) :
                            '';
                    ?>
                    <?php echo (Yii::app()->user->rol == 'superusuario') ? 
                            CHtml::link($remove_image, "#", array(
                                "submit" => array('delete'),
                                'params' => array('mov_id' => $mov->id, 'cuenta_id' => $cuenta->id),
                                'confirm' => '¿Está seguro de querer borrar este movimiento?')) : 
                            ''; ?>
                </td>


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
<p><strong>Total: </strong><?php echo number_format($saldo,0,',','.'); ?></p>
<?php
if (Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'administrativo'  || Yii::app()->user->rol == 'propietario') {
    echo CHtml::link($add_image, Yii::app()->baseUrl . '/index.php/movimiento/create/' . $cuenta->id);
}
?>
<br/>
<script type="text/javascript">
    $(function() {
        $('.footable').footable();
    });
</script>



