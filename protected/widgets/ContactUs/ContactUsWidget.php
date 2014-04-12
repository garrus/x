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

    return <<<SQL
<a target="_blank" style="" href="http://wpa.qq.com/msgrd?v=3&uin=362027034&site=qq&menu=yes">
    <img border="0" src="http://wpa.qq.com/pa?p=2:362027034:51" alt="点击这里给我发消息" title="点击这里给我发消息"/>
</a>

SQL;
    }

} 