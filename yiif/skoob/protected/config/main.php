<?php

require_once( dirname(__FILE__) . '/../components/helpers.php');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Skoob E-Books',
	//'defaultController'=>'egift/index',
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'pass',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		
	),

	// application components
	'components'=>array(
		'session' => array (
			'autoStart' => 'true',
			'class'=>'CDbHttpSession',
			'timeout' => 360,
		),

		'clientScript'=>array(
			'packages' => array(
				'scenario1'=>array(
				 // pass a baseUrl because we don't need to publish 
				 'baseUrl'=>  serverPrefix().dirname($_SERVER['SCRIPT_NAME']).'/css/',   
				 'css'    => array( 'skoob.css','form.css','screen.css','main.css' ),
				 
				),
			),
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
		'detectMobileBrowser' => array(
			'class' => 'ext.yii-detectmobilebrowser.XDetectMobileBrowser',
		),
		'CURL' =>array(
			'class' => 'application.extensions.curl.Curl',
				 //you can setup timeout,http_login,proxy,proxylogin,cookie, and setOPTIONS
			 ),
		'globaldef'=>array( 
			'class' => 'GlobalDef'
				
        ),
		'user'=>array(
			'class' => 'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
		),
		// uncomment the following to enable URLs in path-format
		//changed by adrian to enable clean url
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'rules'=>array(
				'checkout/create/<egift_id:\d+>'=>'checkout/create',
				'checkout/preview/<egift_id:\d+>'=>'checkout/preview',
				'checkout/thankyou/<egift_id:\d+>'=>'checkout/thankyou',
				'checkout/buy_gift/<id:\d+>'=>'checkout/buy_gift',
				'checkout/cancel/<id:\d+>'=>'checkout/cancel',
				'egift/preview/<egift_id:\d+>'=>'egift/preview',
				'egift/create/<id:\d+>'=>'egift/create',
				'egift/claim_gift/<user_name>/<user_password>/<voucher_no>'=>'egift/claim_gift',
				'/emailSent/egiftClaim/<checkout_id:\d+>'=>'/emailSent/egiftClaim',
				'/emailSent/deliveredEgift/<checkout_id:\d+>'=>'/emailSent/deliveredEgift',
				'/emailSent/orderReceipt/<checkout_id:\d+>'=>'/emailSent/orderReceipt',
				'/emailSent/egiftRequested/<sender_name>/<sender_email>/<recipient_name>/<recipient_email>/'=>'/emailSent/egiftRequested',				'/emailSent/egiftVoucherClaimed/<sender_name>/<sender_email>/<recipient_name>/<recipient_email>/<code>/<voucher_value>/<redeem_date>'=>'/emailSent/egiftVoucherClaimed',
				'login'=>'login',
			),
		),
		
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=skoob',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => 'password',
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
					'levels'=>'error, warning, info, debug',
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
		'base_url'=>'http://localhost:81/yiif/skoob',
	),
	
	// to go to this class first to switch theme if mobile view
	'onBeginRequest'=>array('ThemeSwitch', 'BeginRequest'),
);