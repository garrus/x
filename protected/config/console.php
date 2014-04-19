<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

date_default_timezone_set('Asia/Shanghai');

Yii::setPathOfAlias('bootstrap', dirname(__DIR__).'/extensions/bootstrap');


$config = array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
        'bootstrap.widgets.*',
        'application.utils.*',
    ),


    // application components
	'components'=>array(
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=db',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),
);

if (file_exists(__DIR__. '/_local.php')) {
    $localConfig = require __DIR__. '/_local.php';
    if (is_array($localConfig)) {
        return CMap::mergeArray($config, $localConfig);
    }
}

return $config;