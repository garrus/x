<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 14-1-21
 * Time: 上午12:36
 * To change this template use File | Settings | File Templates.
 */

class BaseTestCase extends CDbTestCase{

    protected function getMockApi($route, array $controllerAttributes=array()){

        if (strpos($route, '/')) {
            list($controllerId, $apiName) = explode('/', $route, 2);
            $methodName = 'api'. ucfirst($apiName);
            $controllerClass = ucfirst($controllerId). 'Controller';
            if (is_subclass_of($controllerClass, 'ApiController')
                && method_exists($controllerClass, $methodName)) {

                /** @var ApiController $controller */
                $controller = new $controllerClass($controllerId);
                foreach ($controllerAttributes as $key => $value) {
                    $controller->$key = $value;
                }
                $controller->init();

                return new MockApiAction($this, $controller, new ReflectionMethod($controller, $methodName));
            } else {
                throw new InvalidArgumentException('Test case error! Cannot find a valid api by route '. $route);
            }
        } else {
            throw new InvalidArgumentException('Test case error! Invalid route '. $route);
        }
    }

    protected function setUpSession(User $user){

        /** @var WebUser $webUser */
        $webUser = Yii::app()->user;
        $_SERVER['HTTP_USER_TOKEN'] = $user->token;
        $webUser->authorizeWithToken();

        $this->assertEquals($user->id, $webUser->id);
        return $webUser;
    }


    /**
     * @param string $alias
     * @return User
     */
    public function getUser($alias){
        return $this->getFixtureRecord('users', $alias);
    }


    /**
     * @param string $alias
     * @return Picture
     */
    public function getPicture($alias){
        return $this->getFixtureRecord('pictures', $alias);
    }

}