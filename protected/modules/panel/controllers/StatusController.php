<?php

/**
 * This controller manage the status of SSI website
 *
 * @package test.controllers
 * @author yaowenh
 *
 */
class StatusController extends PanelController
{

	public $defaultAction = 'readLog';


	/**
	 * Check the current status of SSI website
	 *
	 * Output 'ok' with 200 as http status code if status is good.
	 * Otherwise output 500 error and the error message.
	 */
	public static function actionCheck(){
		sleep(1);
		ob_start();

		$error = '';
		try {
			Yii::app()->db->createCommand('SHOW TABLES;')->queryAll();
		} catch (Exception $e) {
			$error = 'Database connection failed';
		}

		if (empty($error)) {
			$idmeVersionCheck = self::checkIDMEVersion();
			$error = $idmeVersionCheck['info'];
		}

		ob_end_clean();

		if (empty($error)) {
			echo 'ok';
		} else {
			@header('http/1.1 500 '.$error);
			echo $error;
		}

	}

	public function actionReadLog(){

		$logPath = Yii::app()->runtimePath;
		if (!isset($_GET['log'])) {

			foreach ( new DirectoryIterator($logPath) as $file ) {
				if ( $file->isFile() && preg_match('/\.log(.(\d+))?$/i', $file->getBasename()) ) {
					$list[] = $file->getBasename();
				}
			}

			sort($list);
			$this->render('readLog', array(
				'list' => $list,
			));
		} elseif (Yii::app()->request->isAjaxRequest) {
			$logFileName = $logPath . '/' . $_GET['log'];
			if (file_exists($logFileName)) {
				$content = file_get_contents($logFileName);
			} else {
				$content = 'File Not Found';
			}

			$this->renderPartial('_logView', array(
				'log' => $_GET['log'],
				'content' => $content,
			));
		} else {
			$this->redirect(Yii::app()->request->baseUrl .'/protected/runtime/' . $_GET['log']);
		}

	}

	public function actionPhpInfo(){
		phpinfo();
	}

	public function actionCleanLog(){

		if (isset($_REQUEST['log'])) {
			unlink(Yii::app()->runtimePath . '/' . $_REQUEST['log']);
		}
		$this->redirect(array('readlog'));
	}


	public function actionShowConstance(){
		$this->dump(get_defined_constants(true), 'defined_constants');
	}

	public function actionShowServer(){
		$this->dump($_SERVER, 'Server');
	}

	public function actionShowSession(){
		if (!session_id()) {
			session_start();
		}
		$this->dump($_SESSION, 'Session');
	}

	public function actionShowJsonServer($name=''){

		$content = json_encode($_SERVER);

		file_put_contents(Yii::app()->runtimePath . '/server.txt', $content);
		header('Content-type:application/javascript');
		echo $content;
		die;

	}
}
