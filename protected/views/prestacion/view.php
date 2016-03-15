<?php
/* @var $this PrestacionController */
/* @var $model Prestacion */


$this->breadcrumbs=array(
	'Prestaciones'=>array('admin'),
	'Prestación #'.$model->id,
);

$this->menu=array(
	array('label'=>'Crear Prestación', 'url'=>array('create')),
	array('label'=>'Editar Prestación', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Prestación', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Seguro quiere eliminar esta prestación?')),
	array('label'=>'Administrar Prestaciones', 'url'=>array('admin')),
);
?>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'fecha', 'value'=>Tools::backFecha($model->fecha)),
                array('name'=>'propiedad', 'value'=>$model->propiedad_id != null?Propiedad::model()->findByPk($model->propiedad_id)->nombre:'','visible'=>$model->propiedad_id!=null),
		'monto',
		'documento',
		'descripcion',
		array('name'=>'tipo_prestacion_nombre', 'value'=>$model->tipoPrestacion->nombre),
		array('name'=>'ejecutor', 'value'=>$model->ejecutor->nombre),
		array('name'=>'genera_cargos', 'value'=>Tools::backGeneraCargos($model->genera_cargos)),
                array('name'=>'general_prop', 'value'=>Tools::backGeneraCargos($model->general_prop)),
	),
)); ?>

<fieldset>
    <legend>Departamentos en los que se ejecutó la prestación</legend>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'id' => 'departamentos-grid',
        'dataProvider' => $departamentos,
        'columns'=>array(
            array('name'=>'propiedad_nombre','value'=>'$data->propiedad->nombre'),
            'numero',
            'mt2',
            'dormitorios',
            'estacionamientos',
            'renta',
         ),
      ));
    ?>
</fieldset>

