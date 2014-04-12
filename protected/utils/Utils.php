<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 14-1-14
 * Time: 上午12:56
 * To change this template use File | Settings | File Templates.
 */

class Utils {

    /**
     * Returns the first validation error of the modal.
     * If there is no error, returns empty string.
     *
     * @param CModel $model
     * @return string
     */
    public static function modelError(CModel $model){
        $errors = $model->getErrors();
        if (count($errors)) {
            foreach ($errors as $attribute => $attrErrors) {
                if (count($attrErrors)) {
                    return end($attrErrors);
                }
            }
        }
        return '';
    }

    /**
     * @param string $str
     * @return bool
     */
    public static function isRegularExpression($str){

        return is_string($str)
            && strlen($str)
            && $str[0] == '/'
            && substr_compare($str, '/', -1) == 0;
    }
}