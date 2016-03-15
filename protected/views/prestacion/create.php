<?php

$this->breadcrumbs=array(
    'Prestaciones'=>array('admin'),
    'Nueva Prestación',
);

?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'departamentos'=>$departamentos)); ?>
