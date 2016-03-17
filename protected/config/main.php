<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');
// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.


return array(
    'theme' => 'bootstrap', // requires you to copy the theme under your themes directory
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'Inmobiliaria',
    'language' => 'es',
    // preloading 'log' component
    'preload' => array('log'),
    // autoloading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    'modules' => array(
        /*'gii' => array(
            'class'=>'system.gii.GiiModule',
            'password' => '12345',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii',
            ),
        ),*/
    ),
    'components' => array(
        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
        'widgetFactory' => array(
            'widgets' => array(
                'CLinkPager' => array(
                    'htmlOptions' => array(
                        'class' => 'pagination'
                    ),
                    'header' => false,
                    'maxButtonCount' => 5,
                    'cssFile' => false,
                ),
                'CGridView' => array(
                    'htmlOptions' => array(
                        'class' => 'table-responsive'
                    ),
                    //'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                    'itemsCssClass' => 'table table-striped table-hover',
                    'cssFile' => false,
                    'summaryCssClass' => 'dataTables_info',
                    'summaryText' => 'Mostrando {start} a {end} de {count} registros',
                    'template' => '{items}<div class="row"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
                ),
                'SelGridView' => array(
                    'htmlOptions' => array(
                        'class' => 'table-responsive'
                    ),
                    //'pagerCssClass' => 'dataTables_paginate paging_bootstrap',
                    'itemsCssClass' => 'table table-striped table-hover',
                    'cssFile' => false,
                    'summaryCssClass' => 'dataTables_info',
                    'summaryText' => 'Mostrando {start} a {end} de {count} registros',
                    'template' => '{items}<div class="row"><div class="col-md-5 col-sm-12">{summary}</div><div class="col-md-7 col-sm-12">{pager}</div></div><br />',
                ),
            ),
        ),
        'user' => array(
            // enable cookie-based authentication
            'allowAutoLogin' => true,
        ),
        // uncomment the following to enable URLs in path-format
        'excel' => array(
            'class' => 'application.extensions.PHPExcel',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'rules' => array(
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),
        /*
          'db'=>array(
          'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
          ),
          // uncomment the following to use a MySQL database
         */
        'authManager' => array(
            'class' => 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=inmobil1_bd',
            'emulatePrepare' => true,
            'username' => 'inmobil1_user',
            'password' => '5TP{zRSEoR*J',
            'charset' => 'utf8',
        ),
        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            // uncomment the following to show log messages on web pages
            /*
              array(
              'class'=>'CWebLogRoute',
              ),
             */
            ),
        ),
    ),
    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'webmaster@example.com',
    ),
);

//return array(
//        'theme'=>'inmobiliaria',
//	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
//	'name'=>'Inmobiliaria',
//        'language'=>'es',
//	// preloading 'log' component
//	'preload'=>array('log'),
//
//	// autoloading model and component classes
//	'import'=>array(
//		'application.models.*',
//		'application.components.*',
//	),
//    
//        
//
//	'modules'=>array(
//		// uncomment the following to enable the Gii tool
//		
//		'gii'=>array(
//			'class'=>'system.gii.GiiModule',
//			'password'=>'12345',
//			// If removed, Gii defaults to localhost only. Edit carefully to taste.
//			'ipFilters'=>array('127.0.0.1','::1'),
//		),
//		
//	),
//
//	// application components
//	'components'=>array(
//		'user'=>array(
//			// enable cookie-based authentication
//			'allowAutoLogin'=>true,
//		),
//		// uncomment the following to enable URLs in path-format
//		'excel'=>array(
//                    'class'=>'application.extensions.PHPExcel',
//                ),
//            
//		'urlManager'=>array(
//			'urlFormat'=>'path',
//			'rules'=>array(
//				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
//				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
//				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
//			),
//		),
//		/*
//		'db'=>array(
//			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
//		),
//		// uncomment the following to use a MySQL database
//		*/
//                'authManager'=>array(
//				'class'=>'CDbAuthManager',
//				'connectionID'=>'db',
//		),
//		'db'=>array(
//			'connectionString' => 'mysql:host=localhost;dbname=inmobiliaria',
//			'emulatePrepare' => true,
//			'username' => 'root',
//			'password' => '',
//			'charset' => 'utf8',
//		),
//		
//		'errorHandler'=>array(
//			// use 'site/error' action to display errors
//			'errorAction'=>'site/error',
//		),
//		'log'=>array(
//			'class'=>'CLogRouter',
//			'routes'=>array(
//				array(
//					'class'=>'CFileLogRoute',
//					'levels'=>'error, warning',
//				),
//				// uncomment the following to show log messages on web pages
//				/*
//				array(
//					'class'=>'CWebLogRoute',
//				),
//				*/
//			),
//		),
//	),
//
//	// application-level parameters that can be accessed
//	// using Yii::app()->params['paramName']
//	'params'=>array(
//		// this is used in contact page
//		'adminEmail'=>'webmaster@example.com',
//	),
//);