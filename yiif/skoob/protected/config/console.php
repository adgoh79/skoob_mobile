<?php
require_once( dirname(__FILE__) . '/../components/helpers.php');
// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'My Console Application',

	// preloading 'log' component
	'preload'=>array('log'),
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),	
	// application components
	'components'=>array(
		/*'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=skoob',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'password',
			'charset' => 'utf8',
		),
		
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning, info, debug',
				),
			),
		),
		'globaldef'=>array( 
			'class' => 'GlobalDef'
				
        ),
		'mail' => array(
			'class' => 'ext.yii-mail.YiiMail',
			'transportType' => 'smtp',
			'transportOptions'=>array(
			   'host'=>'smtp.gmail.com',
			   'username'=>'adgoh79@gmail.com',
			   'password'=>'13081979',
			   'port'=>'465',
			   'encryption'=>'ssl',
			 ),
			'viewPath' => 'application.views.mail',
			'logging' => true,
			'dryRun' => false,
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
		'base_url'=>'http://localhost:81/yiif/skoob',
	),
);