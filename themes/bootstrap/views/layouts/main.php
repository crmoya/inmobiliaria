<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php Yii::app()->bootstrap->register(); ?>
        <script src="<?php echo Yii::app()->theme->baseUrl."/js/swal/sweetalert.min.js"?>"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/js/swal/sweetalert.css" />
    </head>

    <body>

        <?php
        if (Yii::app()->user->isGuest) {
            $this->widget('bootstrap.widgets.TbNavbar', array(
                'items' => array(
                    array(
                        'class' => 'bootstrap.widgets.TbMenu',
                        'items' => array(
                            array('label' => 'Inicio', 'url' => array('/site/index'),),
                            array('label' => 'Login', 'url' => array('/site/login'),),
                        ),
                    ),
                ),
            ));
        } else {
            if (Yii::app()->user->rol == 'superusuario') {
                $this->widget('bootstrap.widgets.TbNavbar', array(
                    'items' => array(
                        array(
                            'class' => 'bootstrap.widgets.TbMenu',
                            'items' => array(
                                array('label' => 'Inicio', 'url' => array('/site/index'),),
                                array('label' => 'Archivo', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Propietario', 'url' => array('/propietario/admin')),
                                        array('label' => 'Propiedades', 'url' => array('/propiedad/admin')),
                                        array('label' => 'Departamentos', 'url' => array('/departamento/admin')),
                                        array('label' => 'Formato de Contratos', 'url' => array('/tipoContrato/admin')),
                                        array('label' => 'Formato de Cartas', 'url' => array('/formatoCarta/admin')),
                                        array('label' => 'Formato de Demandas Judiciales', 'url' => array('/formatoDemanda/admin')),
                                        array('label' => 'Maestros', 'url' => array('/ejecutor/admin')),
                                        array('label' => 'Especialidades', 'url' => array('/especialidad/admin')),
                                        array('label' => 'Tipos de Prestaciones', 'url' => array('/tipoPrestacion/admin')),
                                        array('label' => 'IPC', 'url' => array('/ipc/admin')),
                                        array('label' => 'Centros de Costo', 'url' => array('/centroCosto/admin')),
                                        array('label' => 'Conceptos Predefinidos', 'url' => array('/conceptoPredefinido/admin')),
                                        array('label' => 'Usuarios', 'url' => array('/usuario/admin')),
                                    ),
                                ),
                                array('label' => 'Mi Cuenta (' . Yii::app()->user->name . ')', 'url' => array('#'),
                                    'items' => array(
                                        array('label' => 'Cerrar Sesión', 'url' => array('/site/logout')),
                                        array('label' => 'Cambiar mi Clave', 'url' => array('/site/cambiarClave')),
                                    ))
                            ),
                        ),
                    ),
                ));
            }else if (Yii::app()->user->rol == 'propietario') {
                $this->widget('bootstrap.widgets.TbNavbar', array(
                    'items' => array(
                        array(
                            'class' => 'bootstrap.widgets.TbMenu',
                            'items' => array(
                                array('label' => 'Deptos.', 'url' => array('/departamento/admin'),
                                ),
                                array('label' => 'Contratos', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Ingresar nuevo Cliente', 'url' => array('/cliente/create')),
                                        array('label' => 'Crear nuevo Contrato', 'url' => array('/contrato/create')),
                                        array('label' => 'Ver Contratos vigentes', 'url' => array('contrato/admin')),
                                        array('label' => 'Ver Contratos finiquitados', 'url' => array('/contrato/adminFiniquitados')),
                                    ),
                                ),
                                array('label' => 'Ctas. Corrientes', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Contratos a reajustar el próximo mes', 'url' => array('/contrato/adminAReajustar')),
                                        array('label' => 'Abonos/Cargos de clientes', 'url' => array('/contrato/adminAbonos')),
                                        array('label' => 'Clientes Morosos', 'url' => array('/cuentaCorriente/adminMorosos')),
                                        array('label' => 'Planilla de Ingresos', 'url' => array('/cuentaCorriente/planillaIngresos')),
                                        array('label' => 'Ingresos de Cliente por fecha', 'url' => array('/cuentaCorriente/ingresosCliente')),
                                    ),
                                ),
                                array('label' => 'Cobros', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Enviar avisos', 'url' => array('/contrato/adminAvisos')),
                                        array('label' => 'Demandas Judiciales', 'url' => array('demandaJudicial/admin')),
                                    ),
                                ),
                                array('label' => 'Prestaciones', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Listado de Prestaciones', 'url' => array('/prestacion/admin')),
                                        array('label' => 'Planilla de Prestaciones', 'url' => array('/prestacion/listado')),
                                        array('label' => 'Especialidades', 'url' => array('/especialidad/admin')),
                                        array('label' => 'Maestros', 'url' => array('/ejecutor/admin')),
                                    ),
                                ),
                                array('label' => 'Egresos', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Listado de Egresos', 'url' => array('/egreso/admin')),
                                        array('label' => 'Planilla de Egresos', 'url' => array('/egreso/listado')),
                                    ),
                                ),
                                array('label' => 'Muebles', 'url' => array('admin'),
                                    'items' => array(
                                        array('label' => 'Contrato bienes Muebles', 'url' => array('/contratoMueble/admin')),
                                        array('label' => 'Inventario Bienes Muebles', 'url' => array('/mueble/admin')),
                                    ),
                                ),
                                array('label' => 'Mi Cuenta (' . Yii::app()->user->name . ')', 'url' => array('#'),
                                    'items' => array(
                                        array('label' => 'Cerrar Sesión', 'url' => array('/site/logout')),
                                        array('label' => 'Cambiar mi Clave', 'url' => array('/site/cambiarClave')),
                                    ))
                            ),
                        ),
                    ),
                ));
            }else if (Yii::app()->user->rol == 'cliente') {
                $this->widget('bootstrap.widgets.TbNavbar', array(
                    'items' => array(
                        array(
                            'class' => 'bootstrap.widgets.TbMenu',
                            'items' => array(
                                array('label' => 'Inicio', 'url' => array('/site/index'),),
                                array('label' => 'Archivo', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Departamentos', 'url' => array('/departamento/admin')),
                                    ),
                                ),
                                array('label' => 'Movimientos', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Contratos', 'url' => array('contrato/admin')),
                                        array('label' => 'Movimientos de cuentas', 'url' => array('movimiento/indexContract')),
                                        array('label' => 'Contrato bienes Muebles', 'url' => array('/contratoMueble/admin')),
                                    ),
                                ),
                                array('label' => 'Mi Cuenta (' . Yii::app()->user->name . ')', 'url' => array('#'),
                                    'items' => array(
                                        array('label' => 'Cerrar Sesión', 'url' => array('/site/logout')),
                                        array('label' => 'Cambiar mi Clave', 'url' => array('/site/cambiarClave')),
                                    ),)
                            ),
                        ),
                    ),
                ));
            }
        }
        ?>

        <div class="container" id="page">

            <?php if (isset($this->breadcrumbs)): ?>
                <?php
                $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                    'links' => $this->breadcrumbs,
                ));
                ?><!-- breadcrumbs -->
            <?php endif ?>

            <?php echo $content; ?>

            <div class="clear"></div>

            

        </div><!-- page -->
        <div id="footer">
            <a href="http://www.mvs.cl">MVS Ingeniería</a> <br/><br/>
        </div><!-- footer -->
    </body>
</html>
