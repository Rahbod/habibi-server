<?php
return array(
	'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
	'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'تعمیرکار',
	'timeZone' => 'Asia/Tehran',
	'theme' => 'abound',
	'sourceLanguage' => '00',
	'language' => 'fa_ir',
	// preloading 'log' component
	'preload'=>array('log','userCounter'),

	// autoloading model and component classes
	'import'=>array(
		'application.vendor.*',
		'application.models.*',
		'application.components.*',
		'ext.yiiSortableModel.models.*',
		'ext.dropZoneUploader.*',
		'application.modules.places.models.*',
		'application.modules.setting.models.*',
		'application.modules.requests.models.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'1',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		'admins',
		'users',
		'setting',
		'pages',
		'places',
		'contact',
        'requests',
	),

	// application components
	'components'=>array(
		'request'=>array(
			'class' => 'YMHttpRequest',
			'enableCsrfValidation'=>true,
			'noValidationRoutes'=>array(
				'api/'
			),
		),
		'JWT' => array(
			'class' => 'ext.jwt.JWT',
			'key' => base64_encode(md5('Rahbod-Habibi-1397')),
		),
		'JWS' => array(
			'class' => 'ext.jwt.JWT',
			'key' => base64_encode(sha1('Rahbod-Habibi-1397')),
		),
		'yexcel' => array(
			'class' => 'ext.yexcel.Yexcel'
		),
		'mellat' => array(
			'class'=> 'ext.mellatPayment.MellatPayment',
			'terminalId' => '',
			'userName' => '',
			'userPassword' => ''
		),
		'zarinpal' => array(
			'class'=> 'ZarinPal',
			'merchant_id' => ''
		),
		'session' => array(
			'class' => 'YmDbHttpSession',
			'autoStart' => false,
			'connectionID' => 'db',
			'sessionTableName' => 'ym_sessions',
			'timeout' => 1800
		),
		'userCounter' => array(
			'class' => 'application.components.UserCounter',
			'tableUsers' => 'ym_counter_users',
			'tableSave' => 'ym_counter_save',
			'autoInstallTables' => true,
			'onlineTime' => 10, // min
		),
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
			'class' => 'WebUser',
			'loginUrl'=>array('/login'),
//			'allowActiveSessions'=>2,
		),
		'authManager'=>array(
			'class'=>'CDbAuthManager',
			'connectionID'=>'db',
		),
		// uncomment the following to enable URLs in path-format
		// @todo change rules in projects
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'appendParams'=>true,
			'rules'=>array(
				'sitemap'=>'site/sitemap',
				'sitemap.xml'=>'site/sitemapxml',
				'dealership' => 'users/public/dealership',
				'<action:(about|contact|help|terms|search)>' => 'site/<action>',
				'<action:(logout|dashboard|googleLogin|transactions|login|register|changePassword|profile)>' => 'users/public/<action>',
				'<module:\w+>/<id:\d+>'=>'<module>/manage/view',
				'<module:\w+>/<controller:\w+>'=>'<module>/<controller>/index',
				'<controller:\w+>/<action:\w+>/<id:\d+>/<title:(.*)>'=>'<controller>/<action>',
				'<controller:\w+>/<id:\d+>/<title:(.*)>'=>'<controller>/view',
				'<module:\w+>/<controller:\w+>/<id:\d+>/<title:\w+>'=>'<module>/<controller>/view',
				'<module:\w+>/<action:\w+>/<id:\d+>/<title:(.*)>'=>'<module>/manage/<action>',
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>/<id:\d+>'=>'<module>/<controller>/<action>/view',
				'<module:\w+>/<controller:\w+>/<action:\w+>'=>'<module>/<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<action:\w+>/<title:\w+>'=>'<module>/<controller>/<action>',
				'<module:\w+>/<controller:\w+>/<id:\d+>'=>'<module>/<controller>/view',
			),
		),

		// database settings are configured in database.php
		'db'=>require(dirname(__FILE__).'/database.php'),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class' => 'CFileLogRoute',
					'levels'=>'error, warning, trace, info',
					'categories'=>'application.*',
				),
				// uncomment the following to show log messages on web pages
				array(
					'class' => 'CWebLogRoute',
					'enabled' => YII_DEBUG,
					'levels'=>'error, warning, trace, info',
					'categories'=>'application.*',
					'showInFireBug' => true,
				),
			),
		),
		'clientScript'=>array(
			//'class'=>'ext.minScript.components.ExtMinScript',
			'coreScriptPosition' => CClientScript::POS_HEAD,
			'defaultScriptFilePosition' => CClientScript::POS_END,
		),
	),
	'controllerMap' => array(
		'min' => array(
			'class' =>'ext.minScript.controllers.ExtMinScriptController',
		),
	),
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// @todo change webmail of emails
		'adminEmail'=>'info@carcadeh.ir',
		'noReplyEmail' => 'noreply@carcadeh.ir',
		'SMTP' => array(
			'Host' => 'mail.carcadeh.ir',
			'Secure' => 'ssl',
			'Port' => '465',
			'Username' => 'noreply@carcadeh.ir',
			'Password' => '@#visit1396',
		)
	),
);
