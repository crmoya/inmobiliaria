<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */

$this->breadcrumbs=array(
	'Demandas Judiciales'=>array('admin'),
	'Administrar',
);

$this->menu=array(
	array('label'=>'Crear Demanda Judicial', 'url'=>array('create')),
);
?>

<?php $this->widget('bootstrap.widgets.TbAlert', array(
    'fade'=>true, // use transitions?
    'closeText'=>'&times;', // close link text - if set to false, no close link is displayed
    'alerts'=>array( // configurations per alert type
        'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
        'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'&times;'), // success, info, warning, error or danger
      ),)
); ?>
<script>
$(document).ready(function(e){
    window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 5000);
});
</script> 

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'demanda-judicial-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rol',
		'causa',
                array('name'=>'cliente_rut','value'=>'$data->contrato->cliente->rut'),
                array('name'=>'cliente_nombre','value'=>'$data->contrato->cliente->usuario->nombre." ".$data->contrato->cliente->usuario->apellido'),
		array('name'=>'formato','value'=>'$data->formatoDemanda->nombre'),
		array(
                        'class'=>'CButtonColumn',
                        'template'=>'{view} {delete}',
                        'header'=>'Acciones',
                        'buttons'=>array(
                            'view'=>array(
                               'label'=>'Ver esta demanda',
                               'imageUrl'=>Yii::app()->baseUrl.'/images/download.png',
                            ),                            
                        ),
		),
	),
)); ?>
