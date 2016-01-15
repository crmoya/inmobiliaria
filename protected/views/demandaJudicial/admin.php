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

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#demanda-judicial-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
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

<h1>Administrar Demandas Judiciales</h1>

<?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'demanda-judicial-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'rol',
		'causa',
                array('name'=>'cliente_rut','value'=>'$data->contrato->cliente->rut'),
                array('name'=>'cliente_nombre','value'=>'$data->contrato->cliente->usuario->nombre." ".$data->contrato->cliente->usuario->apellido'),
		array('name'=>'folio','value'=>'$data->contrato->folio'),
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
