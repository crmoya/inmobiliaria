<?php
$this->breadcrumbs=array(
	'Contratos vigentes'=>Yii::app()->user->returnUrl,
	'Movimientos de la cuenta #'.$cuenta->id,
);
$movimientos = Movimiento::model()->findAll(
                array(  'condition'=>'cuenta_corriente_id = :cuenta',
                        'params'=>array(':cuenta'=>$cuenta->id),
                        'order'=>'fecha',
                    )
            );
?>

<div class="span5"><h4>Cuenta Corriente: <?php echo $cuenta->nombre; ?></h4></div>
<div class="clearfix"></div>
<div class="span5"><p>Detalle de los movimientos asociados la Cuenta Corriente</p></div>
<div class="span1"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/add.png'),array('//movimiento/abonar/'.$cuenta->id));?></div>
<div class="span1"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/sub.png'),array('//movimiento/cargar/'.$cuenta->id));?></div>
<div class="clearfix"></div>
<div class="span2">
    <p class='saldo'><strong>Saldo actual: </strong><span id="saldo"/></p>

<table class="table table-hover table-bordered footable" data-filter="#filter" data-page-size="10">
    <thead>
        <tr>
            <th data-sort-initial="descending" data-type='numeric'>Fecha</th>
            <th class="th250">Detalle</th>
            <th>Abono</th>
            <th>Cargo</th>
            <th class="th250">Forma Pago</th>
            <th>Saldo</th>
            <th>Validado</th>
            <?php echo (Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'propietario') ? '<th>Acciones</th>' : '<th></th>'; ?>
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
        foreach ($movimientos as $mov) {
            if ($mov->tipo == Tools::MOVIMIENTO_TIPO_ABONO && $mov->validado == 1) {
                $saldo += $mov->monto;
            }
            if ($mov->tipo == Tools::MOVIMIENTO_TIPO_CARGO)
                $saldo -= $mov->monto;
            ?>
            <tr>
                <td style="width:100px;" data-value="<?php echo strtotime($mov->fecha);?>"><?php echo Tools::backFecha($mov->fecha); ?></td>
                <td style="width:300px;"><?php echo $mov->detalle; ?></td>
                <td><?php echo ($mov->tipo == Tools::MOVIMIENTO_TIPO_ABONO) ? number_format($mov->monto,0,',','.') : ''; ?></td>
                <td><?php echo ($mov->tipo == Tools::MOVIMIENTO_TIPO_CARGO) ? number_format($mov->monto,0,',','.') : ''; ?></td>
                <td><?php echo $mov->formaPago != null?$mov->formaPago->nombre:''; ?></td>
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
                    echo (Yii::app()->user->rol == 'superusuario' || Yii::app()->user->rol == 'propietario') ?
                            CHtml::link($edit_image, 'movimiento/update', array(
                                'submit' => array('movimiento/update'),
                                'params' => array('mov_id' => $mov->id, 'cuenta_id' => $cuenta->id))) :
                            '';
                    ?>
                    <?php echo (Yii::app()->user->rol == 'propietario') ? 
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
</div>
<style>
    .th250{
        width:250px;
        max-width: 250px;
        min-width: 250px;
    }
    .green{
        background:greenyellow;
    }
    .red{
        background: pink;
    }
</style>
<script src="<?php echo Yii::app()->baseUrl?>/js/footable.sort.js" type="text/javascript"></script>
<script type="text/javascript">
    $(function() {
        $('.footable').footable();
        var saldo = '<?php echo number_format($saldo,0,',','.'); ?>';
        $('#saldo').html('$'+saldo);
        if(saldo >= 0){
            $('.saldo').addClass("green");
        }
        else{
            $('.saldo').addClass("red");
        }
    });
</script>



