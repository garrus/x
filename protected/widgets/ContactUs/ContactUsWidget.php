<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-12
 * Time: 下午10:37
 */

class ContactUsWidget extends CWidget{

    public function run(){
        echo $this->getContactCode();
    }

    private function getContactCode(){
        $code = Yii::app()->config->contactQQCode;
        return '<div style="text-align: center;">'. $code. '</div>';
    }

} 