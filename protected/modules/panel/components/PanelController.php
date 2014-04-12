<?php

/**
 *
 * @package test.components
 * @author yaowenh
 *
 */
class PanelController extends \CController {

	public $friendlyName = '';
    public $menu = array();
    public $breadcrumbs = array();

	public $layout = '/layouts/column2b';

	protected $subtitle = '';
	protected $sumary = '';
	protected $body = '';
	protected $assertHistory = array('total' => 0, 'success' => 0, 'failure' => 0);

	public function filters(){
		return array();
	}

	public function secToMsec(&$sec){
		return $sec = substr($sec * 1000, 0, 6) . ' ms';
	}

	public function init(){
		parent::init();

		if (empty($this->friendlyName)) {
			$this->friendlyName = ucwords($this->id);
		}
	}

	protected function startDump(){
		ob_start();
	}

	protected function endDump($title){
		$content = ob_get_clean();
		if ($content === false) {
			$content = new Exception('Wrong output buffering stack.');
			list($newTitle, ) = explode($title, '::assert::');
			$newTitle .= ' Unable to dump ::assert:: [error]';
		}

		$this->dump($content, $title);
	}

	protected function dump($content, $title, $assertFlag='::assert::'){

		if (($ind = stripos($title, $assertFlag)) !== false) {
			$error = false;

			$assertString = trim(substr($title, ($ind + strlen($assertFlag))));

			if (preg_match('/^[(string|double|integer|boolean|null|array|object|error)]$/i', $assertString, $match)) {
				// assert var type
				$error = (strtolower($match[1]) !== strtolower(gettype($content)));
			} elseif (preg_match('/^\{([^\}]+)}$/i', $assertString, $match)) {
				// assert class
				if (is_object($content)) {
					$error = (get_class($content) !== $match[1]);
				}
			} else {
				// assert value
				try {
					$assert = eval('return '.$assertString.'; ?>');
				} catch (Exception $e) {
					$error = true;
				}
				if (!$error) {
					$var_type = gettype($content);
					switch ($var_type) {
						case 'string':
						case 'double':
						case 'integer':
						case 'boolean':
						case 'NULL':
							$error = ($assert !== $content);
							break;
						default:
							break;
					}
				}
			}

			$this->assertHistory['total']++;
			$error ? $this->assertHistory['failure']++ : $this->assertHistory['success']++;

		}

		$this->body .= $this->renderPartial('/common/_dump', array(
			'title' => $title,
			'content' => CVarDumper::dumpAsString($content, 10, true),
			'error' => isset($error) ? $error : null,
		), true);
	}

	protected function dumpNow(){
		call_user_func_array(array($this, 'dump'), func_get_args());
		echo $this->body;
		$this->body = '';
	}

	/*protected function afterAction(CAction $action){

		parent::afterAction($action);

		if (!empty($this->body)) {
			$this->createSumary();
			if ($action->id != 'index') {
				$this->renderOutput();
			}
		}

	}*/

	protected function createSumary(){
		$this->sumary = $this->renderPartial('/common/_sumary', $this->assertHistory, true);
	}

	protected function renderOutput(){

		$this->renderPartial('/common/_report', array(
			'title' => $this->action->id,
		));

	}

}
