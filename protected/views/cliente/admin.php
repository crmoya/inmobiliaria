<?php
/* @var $this ClienteController */
/* @var $model Cliente */


$this->breadcrumbs=array(
	'Clientes'=>array('admin'),
	'Administrar',
);

if(Yii::app()->user->rol != 'propietario'){
$this->menu=array(
	array('label'=>'Crear Cliente', 'url'=>array('create')),
);
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cliente-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Administrar Clientes</h1>

<div class="span4"><?php echo CHtml::link('Búsqueda Avanzada','#',array('class'=>'search-button')); ?></div>
<div class="span4"><?php 
    if(Yii::app()->user->rol != 'propietario'){
        echo CHtml::link('Exportar a Excel',CController::createUrl("/cliente/exportarXLS"),array('class'=>'')); 
    }?></div>
<br/>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cliente-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
            'rut',	
            array('name'=>'nombre', 'value'=>'$data->usuario->nombre'),
            array('name'=>'apellido', 'value'=>'$data->usuario->apellido'),
            array('name'=>'email', 'value'=>'$data->usuario->email'),
            'direccion_alternativa',
            'telefono',
            'ocupacion',
            'renta',
            'clienteFiadors.fiador.rut',
            array(
		'class'=>'CButtonColumn',
                'visible'=>Yii::app()->user->rol != 'propietario',
                'template'=>'{view}{update}{delete}',
                'buttons'=>array(
                    'send'=>array(
                        'label'=>'Enviar carta de aviso',
                        'imageUrl'=>Yii::app()->baseUrl.'/images/sobre.png',
                        'url'=>'Yii::app()->createUrl("//cliente/cartaAviso", array("id"=>$data->id))',
                     ),
                ),
            ),
	),
)); ?>
