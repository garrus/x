<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 14-1-21
 * Time: 上午12:56
 * To change this template use File | Settings | File Templates.
 */

class MockApiAction {

    /**
     * @var PHPUnit_Framework_TestCase
     */
    private $_testCase;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject
     */
    private $_apiHelperMock;

    /**
     * @var ApiController
     */
    private $_controller;

    /**
     * @var ReflectionMethod
     */
    private $_method;

    /**
     * @param PHPUnit_Framework_TestCase $testCase
     * @param ApiController $controller
     * @param ReflectionMethod $method
     */
    public function __construct($testCase, ApiController $controller, ReflectionMethod $method){
        $this->_testCase = $testCase;
        $this->_controller = $controller;
        $this->_method = $method;

        $this->_apiHelperMock = $testCase->getMock('ApiHelper', array('sendText', 'sendJson', 'cleanEnd'));


        $app = Yii::app();
        $property = new ReflectionProperty('CModule', '_components');
        $property->setAccessible(true);
        $property->setValue($app, array_merge($property->getValue($app), array(
            'apiHelper' => $this->_apiHelperMock
        )));
        $property->setAccessible(false);
    }

    public function __destruct(){
        Yii::app()->setComponent('apiHelper', null);
    }

    /**
     * @return PHPUnit_Framework_MockObject_Builder_InvocationMocker
     */
    public function getApiHelperMock(){
        return $this->_apiHelperMock;
    }

    /**
     * @param string $type 'text' | 'json'
     * @return $this
     */
    public function expectSend($type){

        $mock = $this->_apiHelperMock;

        $invoker = $mock->expects($this->_testCase->once())->method('send'. ucfirst($type));
        $with = array_map(array($this, 'createArgConstraint'), array_slice(func_get_args(), 1));
        if (count($with)) {
            call_user_func_array(array($invoker, 'with'), $with);
        } else {
            $invoker->with($this->_testCase->anything());
        }
        return $this;
    }

    /**
     * @param $expect
     * @return PHPUnit_Framework_Constraint
     */
    protected function createArgConstraint($expect){

        if (!is_object($expect)) {
            if (is_callable($expect)) {
                return $this->_testCase->callback($expect);
            } elseif ($expect !== null) {
                return $this->_testCase->equalTo($expect);
            } else {
                return $this->_testCase->anything();
            }
        } else {
            if ($expect instanceof PHPUnit_Framework_Constraint) {
                return $expect;
            } elseif ($expect instanceof Closure) {
                return $this->_testCase->callback($expect);
            } else {
                return $this->_testCase->identicalTo($expect);
            }
        }
    }

    /**
     * @return $this
     */
    public function run(){

        $args = func_get_args();
        if (count($args)) {
            $this->_method->invokeArgs($this->_controller, $args);
        } else {
            $this->_method->invoke($this->_controller);
        }

        return $this;
    }

}