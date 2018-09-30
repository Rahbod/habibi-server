<?php
return array(
	'onBeginRequest'=>create_function('$event', 'return ob_start("ob_gzhandler");'),
	'onEndRequest'=>create_function('$event', 'return ob_end_flush();'),
	'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'آرا خودرو',
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
		'application.modules.lists.models.*',
		'application.modules.car.models.*',
		'application.modules.setting.models.*',
		'application.modules.news.models.*',
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
		'slideshow',
		'map',
		'contact',
		'lists',
		'car',
		'news',
		'newsletters',
		'comments'=>array(
			//you may override default config for all connecting models
			'defaultModelConfig' => array(
				//only registered users can post comments
				'registeredOnly' => true,
				'useCaptcha' => true,
				//allow comment tree
				'allowSubcommenting' => true,
				//display comments after moderation
				'premoderate' => true,
				//action for postig comment
				'postCommentAction' => '/comments/manage/postComment',
				//super user condition(display comment list in admin view and automoderate comments)
				'isSuperuser'=>'Yii::app()->user->checkAccess("moderate")',
				//order direction for comments
				'orderComments'=>'DESC',
				'showEmail' => false
			),
			//the models for commenting
			'commentableModels'=>array(
				//model with individual settings
				'News'=>array(
					'registeredOnly'=>false,
					'useCaptcha'=>false,
					'premoderate' => true,
					'orderComments'=>'DESC',
					//config for create link to view model page(page with comments)
					'module' => 'news',
					'pageUrl'=>array(
						'route'=>'news/',
						'data'=>array('id'=>'id'),
					)
				),
			),
			//config for user models, which is used in application
			'userConfig'=>array(
				'class'=>'Users',
				'nameProperty'=>'userDetails.showName',
				'emailProperty'=>'email',
			),
		),
	),

	// application components
	'components'=>array(
		'request'=>array(
			'class' => 'YMHttpRequest',
			'enableCsrfValidation'=>true,
			'noValidationRoutes'=>array(
				'users/public/verifyPlan'
			),
		),
		'JWT' => array(
			'class' => 'ext.jwt.JWT',
			'key' => base64_encode(md5('Rahbod-AraKhodro-1396')),
		),
		'JWS' => array(
			'class' => 'ext.jwt.JWT',
			'key' => base64_encode(sha1('Rahbod-AraKhodro-1396')),
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
				'news'=>'news/manage/all',
				'news/latest'=>'news/manage/latest',
				'news/tag/<id:\d+>/<title:(.*)>'=>'news/manage/tag',
				'news/<id:\d+>/<title:(.*)>'=>'news/manage/view',
				'sell' => 'car/public/sell',
				'research' => 'car/public/research',
				'research/<params:(.*)>' => 'car/public/research',
				'dealership' => 'users/public/dealership',
				'dealerships' => 'car/search/dealership',
				'dealership/<id:\d+>-<title:(.*)>' => 'car/search/dealership',
				'dealership/<id:\d+>' => 'car/search/dealership',
                'car/<id:\d+>-<title:(.*)>'=>'car/public/view',
				'/help'=>'site/help',
				'<action:(about|contact|help|terms|search)>' => 'site/<action>',
				'<action:(logout|dashboard|googleLogin|transactions|login|register|changePassword|profile|upgradePlan)>' => 'users/public/<action>',
				'<action:(buyPlan|verifyPlan)>/<id:\d+>' => 'users/public/<action>',
				'car/<action:(brand)>/<title:.*>' => 'car/search/<action>',
//				'users/<id:\d+>'=>'users/public/viewProfile',
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
