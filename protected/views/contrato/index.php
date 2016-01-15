<?php
/* @var $this ContratoController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs = array(
    'Contratos',
);
if (Yii::app()->user->rol == 'superusuario' ||
        Yii::app()->user->rol == 'administrativo') {
    $this->menu = array(
        array('label' => 'Crear Contrato', 'url' => array('create')),
        array('label' => 'Administrar Contratos', 'url' => array('admin')),
    );
}
?>

<h1>Contratos</h1>

<?php
$this->widget('zii.widgets.CListView', array(
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
));
?>
