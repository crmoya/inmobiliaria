<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<meta name="language" content="es" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ui-lightness/jquery-ui-1.10.3.custom.css" />

    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-1.9.1.js"> </script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery-ui-1.10.3.custom.js"> </script>
    <script type="text/javascript" src="<?php echo Yii::app()->theme->baseUrl; ?>/js/jquery.Rut.js"> </script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">
	<br/>
	<div id="logo"><h2><?php echo CHtml::encode(Yii::app()->name); ?></h2></div>
	<div id="mainmenu">
    <?php $this->widget('zii.widgets.CMenu',array(
        'htmlOptions'=>array('class'=>'menuDropdown'),
      'items'=>array(
        array('label'=>'Home', 'url'=>array('/site/index'),),
        array('label'=>'Archivo', 'url'=>array('admin'),
          'items'=>array(
            array('label'=>'Propietario', 'url'=>array('/propietario/admin')),
            array('label'=>'Propiedades', 'url'=>array('/propiedad/admin')),
            array('label'=>'Departamentos', 'url'=>array('/departamento/admin')),
            array('label'=>'Conceptos', 'url'=>array('/concepto/admin')),
            array('label'=>'Formato de cartas', 'url'=>array('')),
            array('label'=>'Proveedores', 'url'=>array('/proveedor/admin')),
            array('label'=>'Ejecutores', 'url'=>array('/ejecutor/admin')),
            array('label'=>'Contratos Tipos', 'url'=>array('tipoContrato/admin')),
            array('label'=>'Muebles', 'url'=>array('/mueble/admin')),
            array('label'=>'Tipos de Prestaciones', 'url'=>array('/tipoPrestacion/admin')),
            array('label'=>'Usuarios', 'url'=>array('/usuario/admin')),
          ),
        ),
        array('label'=>'Movimientos', 'url'=>array('admin'),
          'items'=>array(
            array('label'=>'Contratos', 'url'=>array('contrato/admin')),
            array('label'=>'Cuentas Corrientes', 'url'=>array('cuentaCorriente/admin')),
            array('label'=>'Clientes', 'url'=>array('/cliente/admin')),
            array('label'=>'Movimientos de cuentas', 'url'=>array('movimiento/indexType')),
            array('label'=>'Cartas de aviso', 'url'=>array('')),
            array('label'=>'Demandas Judiciales', 'url'=>array('')),
            array('label'=>'Reajustes de renta', 'url'=>array('/reajusteRenta/admin')),
            array('label'=>'Contrato bienes Muebles', 'url'=>array('')),
            array('label'=>'Inventario Bienes Muebles', 'url'=>array('')),
            array('label'=>'Pago de contribuciones', 'url'=>array('')),
            array('label'=>'Compra de materiales', 'url'=>array('')),
            array('label'=>'Prestaciones', 'url'=>array('/prestacion/admin')),
          ),
        ),
        array('label'=>'Consultas', 'url'=>array('admin'),
          'items'=>array(
            array('label'=>'Estado de contratos', 'url'=>array('')),
            array('label'=>'Detalle', 'url'=>array('')),
            array('label'=>'Consulta propiedad', 'url'=>array('')),
            array('label'=>'Consulta Departamento', 'url'=>array('')),
            array('label'=>'Consulta de concepto', 'url'=>array('')),
            array('label'=>'Vencimiento mensual', 'url'=>array('')),
            array('label'=>'Estado demandas Judiciales', 'url'=>array('')),
            array('label'=>'Inventario Bienes Muebles', 'url'=>array('')),
            array('label'=>'Contribuciones', 'url'=>array('')),
            array('label'=>'Movimientos diarios', 'url'=>array('')),
            array('label'=>'Estado de cuenta por arrendatario', 'url'=>array('')),
          ),
        ),
        array('label'=>'Procesos', 'url'=>array('admin'),
          'items'=>array(
            array('label'=>'Cierre mensual', 'url'=>array('')),
            array('label'=>'Declaracion jurada', 'url'=>array('')),
          ),
        ),
        array('label'=>'Login', 'url'=>array('/site/login'), 
            'visible'=>Yii::app()->user->isGuest),
        array('label'=>'Mi Cuenta ('.Yii::app()->user->name.')', 'url'=>array('#'), 
            'items'=>array(
                array('label'=>'Cerrar Sesión', 'url'=>array('/site/logout'),'visible'=>!Yii::app()->user->isGuest),
                array('label'=>'Cambiar mi Clave', 'url'=>array('/site/cambiarClave'),'visible'=>!Yii::app()->user->isGuest),
            ),
            'visible'=>!Yii::app()->user->isGuest)
      ),
    )); ?>
	</div><!-- mainmenu -->
	<br/>
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

<?php
    foreach(Yii::app()->user->getFlashes() as $key => $message) {
        echo '<div class="flash-' . $key . '">' . $message . "</div>\n";
    }
?>
	<?php echo $content; ?>

	<div class="clear"></div>

<br/>
	<div id="footer">

            Sitio creado por <a href="http://www.mvs.cl">MVS Ingeniería</a> <br/>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
