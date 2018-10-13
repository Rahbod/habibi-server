<?php

class RequestsModule extends CWebModule
{
    public $controllerMap = array(
        'manage' => 'requests.controllers.RequestsManageController',
        'tariffs' => 'requests.controllers.RequestsTariffsController',
        'brands' => 'requests.controllers.RequestsBrandsController',
        'categories' => 'requests.controllers.RequestsCategoriesController',
    );

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'requests.models.*',
			'requests.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
