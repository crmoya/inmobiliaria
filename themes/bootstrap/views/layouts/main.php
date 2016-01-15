<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="language" content="en" />

        <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/styles.css" />

        <title><?php echo CHtml::encode($this->pageTitle); ?></title>

        <?php Yii::app()->bootstrap->register(); ?>
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
                                        array('label' => 'Ejecutores', 'url' => array('/ejecutor/admin')),
                                        array('label' => 'Tipos de Prestaciones', 'url' => array('/tipoPrestacion/admin')),
                                        array('label' => 'IPC', 'url' => array('/ipc/admin')),
                                        array('label' => 'Usuarios', 'url' => array('/usuario/admin')),
                                    ),
                                ),
                                array('label' => 'Movimientos', 'url' => array('admin'),
                                    'items' => array(
                                        array('label' => 'Clientes', 'url' => array('/cliente/admin')),
                                        array('label' => 'Contratos', 'url' => array('contrato/admin')),
                                        array('label' => 'Cuentas Corrientes', 'url' => array('cuentaCorriente/admin')),
                                        array('label' => 'Movimientos de cuentas', 'url' => array('movimiento/indexContract')),
                                        array('label' => 'Reajustes de Renta', 'url' => array('/contrato/adminReajustes')),
                                        array('label' => 'Cartas de aviso', 'url' => array('contrato/adminAviso')),
                                        array('label' => 'Demandas Judiciales', 'url' => array('demandaJudicial/admin')),
                                        array('label' => 'Contrato bienes Muebles', 'url' => array('/contratoMueble/admin')),
                                        array('label' => 'Prestaciones', 'url' => array('/prestacion/admin')),
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
            }
            if (Yii::app()->user->rol == 'administrativo') {
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
                                        array('label' => 'Formato de Contratos', 'url' => array('tipoContrato/admin')),
                                        array('label' => 'Formato de Cartas', 'url' => array('/formatoCarta/admin')),
                                        array('label' => 'Formato de Demandas Judiciales', 'url' => array('/formatoDemanda/admin')),
                                        array('label' => 'Ejecutores', 'url' => array('/ejecutor/admin')),
                                        array('label' => 'IPC', 'url' => array('/ipc/admin')),
                                        array('label' => 'Tipos de Prestaciones', 'url' => array('/tipoPrestacion/admin')),
                                    ),
                                ),
                                array('label' => 'Movimientos', 'url' => array('admin'),
                                    'items' => array(
                                        array('label' => 'Clientes', 'url' => array('/cliente/admin')),
                                        array('label' => 'Contratos', 'url' => array('contrato/admin')),
                                        array('label' => 'Cuentas Corrientes', 'url' => array('cuentaCorriente/admin')),
                                        array('label' => 'Movimientos de cuentas', 'url' => array('movimiento/indexType')),
                                        array('label' => 'Reajustes de Renta', 'url' => array('/contrato/adminReajustes')),
                                        array('label' => 'Cartas de aviso', 'url' => array('contrato/adminAviso')),
                                        array('label' => 'Demandas Judiciales', 'url' => array('demandaJudicial/admin')),
                                        array('label' => 'Contrato bienes Muebles', 'url' => array('/contratoMueble/admin')),
                                        array('label' => 'Prestaciones', 'url' => array('/prestacion/admin')),
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
            }
            if (Yii::app()->user->rol == 'propietario') {
                $this->widget('bootstrap.widgets.TbNavbar', array(
                    'items' => array(
                        array(
                            'class' => 'bootstrap.widgets.TbMenu',
                            'items' => array(
                                array('label' => 'Inicio', 'url' => array('/site/index'),),
                                array('label' => 'Archivo', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Propiedades', 'url' => array('/propiedad/admin')),
                                        array('label' => 'Departamentos', 'url' => array('/departamento/admin')),
                                    ),
                                ),
                                array('label' => 'Movimientos', 'url' => array('index'),
                                    'items' => array(
                                        array('label' => 'Clientes', 'url' => array('/cliente/admin')),
                                        array('label' => 'Contratos', 'url' => array('contrato/admin')),
                                        array('label' => 'Cuentas Corrientes', 'url' => array('cuentaCorriente/admin')),
                                        array('label' => 'Movimientos de cuentas', 'url' => array('movimiento/indexPerson')),
                                        array('label' => 'Cartas de aviso', 'url' => array('contrato/adminAviso')),
                                        array('label' => 'Demandas Judiciales', 'url' => array('demandaJudicial/admin')),
                                        array('label' => 'Contrato bienes Muebles', 'url' => array('/contratoMueble/admin')),
                                        array('label' => 'Prestaciones', 'url' => array('/prestacion/admin')),
                                        array('label' => 'Inventario Bienes Muebles', 'url' => array('/mueble/admin')),
                                    ),
                                ),
                                array('label' => 'Informes', 'url' => array('#'),
                                    'items' => array(
                                        array('label' => 'Movimientos de Propietario', 'url' => array('/movimiento/informe')),
                                        array('label' => 'Emisión de contrato', 'url' => array('/site/index')),
                                        array('label' => 'Cartas de Aviso', 'url' => array('/site/index')),
                                    )
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
            }
            if (Yii::app()->user->rol == 'cliente') {
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

            <div id="footer">
                Sitio creado por <a href="http://www.mvs.cl">MVS Ingeniería</a> <br/>
            </div><!-- footer -->

        </div><!-- page -->

    </body>
</html>
