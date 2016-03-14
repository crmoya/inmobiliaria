<?php
/* @var $this DemandaJudicialController */
/* @var $model DemandaJudicial */

$this->breadcrumbs=array(
	'Demanda Judiciales'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'Crear Demanda Judicial', 'url'=>array('create')),
	array('label'=>'Eliminar Demanda Judicial', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro desea eliminar este registro?')),
	array('label'=>'Administrar Demandas Judiciales', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
            'rol',
            'causa',
            array('name'=>'cliente_rut','value'=>$model->contrato->cliente->rut),
            array('name'=>'cliente_nombre','value'=>$model->contrato->cliente->usuario->nombre." ".$model->contrato->cliente->usuario->apellido),
            array('name'=>'formato','value'=>$model->formatoDemanda->nombre),
	),
)); ?>
