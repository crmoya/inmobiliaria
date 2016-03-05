<?php
$this->breadcrumbs=array(
	'Contratos vigentes'=>array('//contrato/admin'),
	'Historial de montos reajustados para el Contrato # '.$contrato->folio,
);
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'debepagar-grid',
	'dataProvider'=>$model->searchContrato($contrato->id),
	'filter'=>$model,
	'columns'=>array(   
                'dia',
		array(  'name'=>'mes',
                        'value'=>'Tools::fixMes($data->mes)',
                        'filter' => CHtml::listData( array(
                                        array('id'=>'1','nombre'=>'ENERO'),
                                        array('id'=>'2','nombre'=>'FEBRERO'),
                                        array('id'=>'3','nombre'=>'MARZO'),
                                        array('id'=>'4','nombre'=>'ABRIL'),
                                        array('id'=>'5','nombre'=>'MAYO'),
                                        array('id'=>'6','nombre'=>'JUNIO'),
                                        array('id'=>'7','nombre'=>'JULIO'),
                                        array('id'=>'8','nombre'=>'AGOSTO'),
                                        array('id'=>'9','nombre'=>'SEPTIEMBRE'),
                                        array('id'=>'10','nombre'=>'OCTUBRE'),
                                        array('id'=>'11','nombre'=>'NOVIEMBRE'),
                                        array('id'=>'12','nombre'=>'DICIEMBRE'),
                                    ), 'id', 'nombre'),
                    ),
		'agno',
		array('name'=>'monto_renta','value'=>'Tools::formateaPlata($data->monto_renta)'),
                array('name'=>'monto_gastocomun','value'=>'Tools::formateaPlata($data->monto_gastocomun)'),
                array('name'=>'monto_mueble','value'=>'Tools::formateaPlata($data->monto_mueble)'),
                array('name'=>'monto_gastovariable','value'=>'Tools::formateaPlata($data->monto_gastovariable)'),
	),
)); 
?>