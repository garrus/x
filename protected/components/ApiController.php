<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 14-1-13
 * Time: 下午9:40
 * To change this template use File | Settings | File Templates.
 */

abstract class ApiController extends CController{


    /**
     * Override this method to set error handlers.
     *
     * @param CAction $action
     * @return bool
     */
    public function beforeAction($action){

        if (parent::beforeAction($action)) {
            if (strcasecmp($action->id, 'dispatch') == 0) {
                $app = Yii::app();
                $app->getEventHandlers('onException')->insertAt(0, array($this, 'handleExceptionEvent'));
                $app->getEventHandlers('onError')->insertAt(0, array($this, 'handleErrorEvent'));
            }

            return true;
        }

        return false;
    }

    /**
     * Override this method so to avoid any attempt that renders a view
     * @param string $view
     * @return bool
     */
    public function beforeRender($view){

        return false; //Not allowed to call $this->render() on an ApiController
    }

    /**
     * @param CAction $action
     */
    protected function afterAction($action){

        Yii::app()->apiHelper->cleanEnd();
    }

    /**
     * @param CExceptionEvent $event
     */
    public function handleExceptionEvent(CExceptionEvent $event){

        $e = $event->exception;

        $msg = $e->__toString(). PHP_EOL. $e->getTraceAsString();
        $msg .= PHP_EOL. 'url = '. Yii::app()->request->url;
        Yii::log($msg, CLogger::LEVEL_ERROR, 'api.'. $this->id);

        if ($e instanceof CHttpException) {
            $this->error($e->getMessage(), $e->statusCode);
        } else {
            $this->error($e->getMessage(), 10001);
        }
    }

    /**
     * @param CErrorEvent $event
     */
    public function handleErrorEvent(CErrorEvent $event){

        $msg = sprintf('[%d] %s at %s Line %d', $event->code, $event->message, $event->file, $event->line);
        $msg .= PHP_EOL. 'url = '. Yii::app()->request->url;
        Yii::log($msg, CLogger::LEVEL_ERROR, 'api.'. $this->id);

        $this->error($event->message. $msg, 10001);
    }

    /**
     *
     */
    public function actionIndex(){
        //TODO
        // this action should list all available API in this controller
        // as well as their docs.
    }

    /**
     * @param $extraPath
     */
    public function actionDispatch($extraPath){

        $tokens = explode('/', $extraPath);
        $method = $this->getApiMethod($tokens[0]);
        if ($method) {
            $this->runApi($method, array_slice($tokens, 1));
        } else {
            $this->error(Yii::t('api', 'Invalid path. Resource not found.'), 404);
        }
    }

    /**
     * @param string $apiName
     * @return ReflectionMethod|null
     */
    private function getApiMethod($apiName){

        $methodName = 'api'. $apiName;
        if ($apiName && method_exists($this, $methodName)) {
            return new ReflectionMethod(get_class($this), $methodName);
        } else {
            return null;
        }
    }

    /**
     * @param ReflectionMethod $apiMethod
     * @param array $pathArgs
     */
    protected function beforeApi($apiMethod, $pathArgs) {

        /** @var ApiHelper $apiHelper */
        $apiHelper = Yii::app()->apiHelper;
        $docComment = $apiMethod->getDocComment();
        $path = implode('/', $pathArgs);

        // @pathFilter
        if (preg_match('/\* \@pathFilter( (.+))/m', $docComment, $matches)) {
            if (!$apiHelper->isPatternMatched($matches[2], $path)) {
                $this->error(Yii::t('api', 'Invalid path. Resource not found.'), 404);
            }
        }

        // @guestAvailable
        $needAuthentication = true;
        if (preg_match('/\* \@guestAvailable( (.+))?/m', $docComment, $matches)) {
            $needAuthentication = !$apiHelper->isPatternMatched(isset($matches[2]) ? $matches[2] : null, $path);
        }
        if ($needAuthentication) {
            $webUser = Yii::app()->user;
            if ($webUser->isGuest && !$webUser->authorizeWithToken()) {
                $this->error(Yii::t('common', 'Authorization is required.'), 401);
            }
        }

        // @postOnly
        if (preg_match('/\* \@postOnly( (.+))?/m', $docComment, $matches)) {
            if (!Yii::app()->request->isPostRequest) {
                if ($apiHelper->isPatternMatched(isset($matches[2]) ? $matches[2] : null, $path)) {
                    $this->error(Yii::t('common', 'Bad request method. Only POST method is accepted.'), 400);
                }
            }
        }

    }

    /**
     * @param ReflectionMethod $apiMethod
     * @param array $pathArgs
     */
    private function runApi($apiMethod, array $pathArgs=array()){

        $this->beforeApi($apiMethod, $pathArgs);

        try {
            $args = Yii::app()->apiHelper->resolveApiArgs($apiMethod, $pathArgs);
        } catch (Exception $e) {
            $this->error(Yii::t('api', 'Invalid request. '. $e->getMessage()), 10003);
        }

        /** @var $args array */
        if (count($args)) {
            $apiMethod->invokeArgs($this, $args);
        } else {
            $apiMethod->invoke($this);
        }

        // normally, the API method should send response itself.
        Yii::log('API '. $apiMethod->getName(). ' didn\'t send response.', CLogger::LEVEL_WARNING, 'api');
        $this->error(Yii::t('api', 'Server gives no response. This request may NOT succeeded.'), 10001);
    }


    /**
     * Convenient method to send a json response on success
     *
     * @param mixed $data
     */
    protected function success($data){

        $this->sendResponse(array('state' => 1, 'data' => $data));
    }

    /**
     * Convenient method to send a json response on error
     *
     * @param string $msg
     * @param int $code [=10001]
     */
    protected function error($msg, $code=10001){

        $this->sendResponse(array(
            'state' => 0,
            'code' => $code,
            'msg' => $msg,
        ));
    }

    /**
     * @param mixed $content
     * @param string $type [=json] available values: json|text|file
     * @param array $options can contain these keys:
     * 'headers' -- an associate array
     * @throws InvalidArgumentException
     * @throws BadMethodCallException
     */
    public function sendResponse($content, $type = 'json', array $options = array()) {

        $apiHelper = Yii::app()->apiHelper;

        switch ($type) {
            case 'json':
                $apiHelper->sendJson($content);
                break;
            case 'text':
                $apiHelper->sendText($content);
                break;
            case 'file':
                if (!isset($options['filename'])) {
                    throw new BadMethodCallException('Options.filename must be set when $type is "file".');
                }
                Yii::app()->request->sendFile($options['filename'], $content);
                break;
            default:
                throw new InvalidArgumentException('Invalid value "' . $type . '" for argument 2. (available values: json|text|file)');
        }
    }

}
