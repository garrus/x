<?php
/**
 *
 * @package test.core
 * @author yaowenh
 *
 */
class PanelModule extends CWebModule{

	public $defaultController = 'default';

	public $backupPath = null;

	public function init(){

		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		//$this->viewPath = Yii::app()->theme->basePath.'/views';

		//$this->setLayoutPath('protected/modules/panel/views/layouts');

		// import the module-level models and components
		$this->setImport(array(
			'panel.models.*',
			'panel.components.*',
			'panel.controllers.*',
		));

        /** @var $log CLogRouter */
		$log = Yii::app()->getComponent('log');
		$logRoutes = $log->routes;
		foreach ($logRoutes as $logRoute) {
			$logRoute->enabled = false;
		}
		
		$debug_log_route = Yii::createComponent(array(
			'class' => 'CWebLogRoute',
			'levels' => 'debug',
			));
		$log->setRoutes(array('debug' => $debug_log_route));
	}

	public function getDescription(){
	   return 'This module is for monitoring.';
	}

	public function beforeControllerAction($controller, $action){

        /** @var $webUser AdminWebUser */
        $webUser = $this->getComponent('webUser');
        Yii::app()->setComponent('user', $webUser);

        if ($controller->id == 'default' && $action->id == 'login') {
            return parent::beforeControllerAction($controller, $action);
        }

        if ($webUser->isGuest) {
            $webUser->loginRequired();
        }
		return parent::beforeControllerAction($controller, $action);
	}

}
