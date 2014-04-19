<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

date_default_timezone_set('Asia/Shanghai');

Yii::setPathOfAlias('bootstrap', dirname(__DIR__).'/extensions/bootstrap');

$config = array(
	'basePath'=>dirname(__DIR__),
	'name'=>'水文仪器',
    'theme' => 'qudao',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
        'bootstrap.widgets.*',
        'application.utils.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=> false,
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1', '192.168.*', '::1'),
            'generatorPaths' => array(
                'bootstrap.gii',
            )
		),

        'panel' => array(
            'class' => 'application.modules.panel.PanelModule',
            'backupPath' => dirname(__DIR__) . '/runtime/backup/',
            'components' => array(
                'webUser' => array(
                    'class' => 'application.modules.panel.components.AdminWebUser',
                    'authFilePath' => dirname(__DIR__) . '/data/admin.crdt',
                    'loginUrl' => array('/panel/default/login'),
                ),
            )
        )
	),

	// application components
	'components'=>array(

        'apiHelper' => array(
            'class' => 'ApiHelper',
        ),

        'config' => array(
            'class' => 'ConfigManager',
            'tableName' => 'config',
        ),

		'user'=>array(
            'class' => 'WebUser',
            'loginUrl' => false,
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

        'bootstrap' => array(
            'class' => 'bootstrap.components.Bootstrap',
        ),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName' => false,
			'rules'=>array(
				'<view:.+>.shtml'=>'site/page',
                '<controller:user|pic>/<extraPath:.+>'=>'<controller>/dispatch',
			),
		),

        // To use your own db, please override this config section in _local.php
        // if you can't see that file, you need to create it on your own, and
        // have it return an array that follows the  structure of this config
        // array exactly. Of course it doesn't have to contain all the index
        // that are in this file, but just the structure need to be followed.
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, profile, info',
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
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);

if (file_exists(__DIR__. '/_local.php')) {
    $localConfig = require __DIR__. '/_local.php';
    if (is_array($localConfig)) {
        return CMap::mergeArray($config, $localConfig);
    }
}

return $config;
