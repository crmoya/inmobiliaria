<?php
/* @var $this EgresoController */
/* @var $model Egreso */

$this->breadcrumbs=array(
	'Egresos'=>array('admin'),
	'Egreso #'.$model->id,
);

$this->menu=array(
	array('label'=>'Listar Egresos', 'url'=>array('admin')),
	array('label'=>'Crear Egreso', 'url'=>array('create')),
	array('label'=>'Actualizar Egreso', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Eliminar Egreso', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
);
?>

<?php 
    $egPro = EgresoPropiedad::model()->findByAttributes(array('egreso_id'=>$model->id));
    $propiedad = null;
    if($egPro != null){
        $propiedad = $egPro->propiedad;
    }
    $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		array('name'=>'fecha','value'=>Tools::backFecha($model->fecha)),
		'monto',
		'concepto',
		array('name'=>'respaldo','value'=>$model->respaldo=='1'?'SÍ':'NO'),
		'cta_contable',
		'nro_cheque',
		'centro_costo_id',
		'proveedor',
		'nro_documento',
                array('name'=>'propiedad_id','value'=>$propiedad!=null?$propiedad->nombre:'','visible'=>$propiedad!=null),
                
	),
)); ?>
<fieldset style="display:<?php echo count(EgresoDepartamento::model()->findAllByAttributes(array('egreso_id'=>$model->id)))==0?'none':'block';?>">
    <legend>Departamentos a los que se aplica el egreso</legend>
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
<br/>
