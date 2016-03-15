<?php
$this->breadcrumbs=array(
	'Contratos vigentes'=>Yii::app()->user->returnUrl,
	'Movimientos de la cuenta #'.$cuenta->id,
);
?>
<?php
$saldo = $cuenta->saldoAFecha(date('Y-m-d'));

Yii::app()->clientScript->registerScript('refresh', "
    function refresh(){
        $.ajax({
            type: 'POST',
            url: '".Yii::app()->createUrl('//cuentaCorriente/getSaldo/')."',
            data: { cuenta_id: ".$cuenta->id." }
        }).done(function(msg){
            $('#saldo').html('$'+msg);
            if(msg >= 0){
                $('.saldo').removeClass('green');
                $('.saldo').removeClass('red');
                $('.saldo').addClass('green');
            }
            else{
                $('.saldo').removeClass('green');
                $('.saldo').removeClass('red');
                $('.saldo').addClass('red');
            }
        });
    }
");
?>

<div class="span5"><h4>Cuenta Corriente: <?php echo $cuenta->nombre; ?></h4></div>
<div class="clearfix"></div>
<div class="span5"><p>Detalle de los movimientos asociados la Cuenta Corriente</p></div>
<div class="span1"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/add.png'),array('//movimiento/abonar/'.$cuenta->id));?></div>
<div class="span1"><?php echo CHtml::link(CHtml::image(Yii::app()->baseUrl.'/images/sub.png'),array('//movimiento/cargar/'.$cuenta->id));?></div>
<div class="clearfix"></div>
<div class="span4">
    <p class='saldo'><strong>Saldo actual: <span id="saldo"></span></strong> (incluye saldo inicial de $<?php echo number_format($cuenta->saldo_inicial,0,",",".");?>)</p>

<div class="span11">
<?php 

    $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'movimiento-grid',
        'afterAjaxUpdate' => 'refresh',
	'dataProvider'=>$mov->searchCartola($cuenta->id),
	'columns'=>array(
            'fecha',
            'detalle',
            array('name'=>'cargo_str','value'=>'$data->cargo'),
            array('name'=>'abono_str','value'=>'$data->abono'),
            array('name'=>'forma_pago_id','value'=>'$data->formaPago!=null?$data->formaPago->nombre:""'),
            'saldo_cuenta',
            array(
                'class'=>'ValidadoButtonColumn',
                'template'=>'{validado}',
                'header'=>'Validado',
                'buttons'=>array
                (
                    'validado' => array
                    (
                        'label'=>'Validar',
                        'url'=>'$data->tipo==Tools::MOVIMIENTO_TIPO_ABONO?Yii::app()->createUrl("//movimiento/validate/$data->id"):""',
                    ),
                ),
            ),
            array(
                'class'=>'CButtonColumn',
                'template'=>'{update}{delete}',
                'buttons'=>array
                (
                    'delete' => array
                    (
                        'label'=>'Eliminar',
                        'url'=>'Yii::app()->createUrl("//movimiento/delete/$data->id")',
                        'imageUrl'=>Yii::app()->baseUrl.'/images/eliminar.png',
                    ),
                    'update' => array
                    (
                        'label'=>'Actualizar',
                        'imageUrl'=>Yii::app()->baseUrl.'/images/edit.png',
                    ),
                ),
            ),
	),
)); ?>
</div>

<style>
    .green{
        background:greenyellow;
    }
    .red{
        background: pink;
    }
</style>
<script type="text/javascript">
    $(function() {
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



