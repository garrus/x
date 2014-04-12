<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 14-1-21
 * Time: 上午1:49
 * To change this template use File | Settings | File Templates.
 */

class ApiHelper extends CApplicationComponent{


    /**
     * @param ReflectionMethod $apiMethod
     * @param array $pathArgs
     *
     * @throws InvalidArgumentException
     * @return array
     */
    public function resolveApiArgs($apiMethod, array $pathArgs){

        if ($apiMethod->getNumberOfParameters() == 0) return array(); // fast return

        $args = array();
        $params = new CMap($_REQUEST); // stores all available parameters from this request
        $params->add('_method', Yii::app()->request->getRequestType());

        // we can fetch some values from the path args first
        if (preg_match('/@fillParamFromPath (\S+)/m', $apiMethod->getDocComment(), $matches)) {
            $i = 0;
            foreach (preg_split('/[^\w_]/i', $matches[1], -1, PREG_SPLIT_NO_EMPTY) as $name) {
                if (isset($pathArgs[$i])) {
                    $params->add($name, $pathArgs[$i++]);
                } else {
                    break;
                }
            }
        }

        foreach ($apiMethod->getParameters() as $param) {
            $name = $param->getName();
            if ($params->contains($name)) {
                $args[] = $params->itemAt($name);
            } elseif ($param->isDefaultValueAvailable()) {
                $args[] = $param->getDefaultValue();
            } else {
                throw new InvalidArgumentException('Missing required parameter '. $name);
            }
        }

        return $args;
    }

    /**
     * Calculate if the API request path matches the pattern.
     * $pattern can be a string or a string represented a regular expression.
     * If $pattern is empty, the result is true.
     *
     * @param $pattern
     * @param $path
     * @return bool
     */
    public function isPatternMatched($pattern, $path){

        if (!empty($pattern) && '' !== ($pattern = trim($pattern))) {
            if (Utils::isRegularExpression($pattern)) {
                // this is a regular expression.
                return (1 == preg_match($pattern, $path));
            } else {
               return (false !== strpos($path, $pattern));
            }
        }
        return true;
    }

    public function filterPostOnly($pattern=null){
        if (!Yii::app()->request->isPostRequest) {

        }
    }

    public function sendJson($data){

        if (!headers_sent()) {
            header('Content-Type:text/json;charset=utf8');
        }
        echo json_encode($data);
        $this->cleanEnd();
    }

    public function sendText($text){
        if (!headers_sent()) {
            header('Content-Type:text/plain;charset=utf8');
        }
        echo $text;
        $this->cleanEnd();
    }

    /**
     * End this request
     */
    private function cleanEnd(){
        ob_start();
        Yii::app()->end(0, false);
        ob_end_clean();
        Yii::app()->end();
    }

    public function ensureInteger(&$number, $min=null, $max=null){

        if (is_numeric($number)) {
            $number = round($number);
            if ($min !== null && $number < $min) {
                $number = $min;
            }
            if ($max !== null & $number > $max) {
                $number = $max;
            }
            return true;
        } else {
            return false;
        }

    }

    /**
     * @param $string
     * @param $pattern
     * @return false|array
     */
    public function ensurePattern($string, $pattern){

        if (!is_string($string)) {
            return false;
        }

        if (preg_match($pattern, $string, $matches)) {
            return $matches;
        }

        return false;
    }

    /**
     * Ensure the parameters are not null.
     *
     * @param array $parameters
     */
    public function ensureParameters(array $parameters){

        foreach ($parameters as $key => $value) {
            if ($value === null) {
                $this->sendJson(array(
                    'state' => 0,
                    'code' => 10003,
                    'msg' => 'Missing required parameter '. $key,
                ));
            }
        }

    }
}