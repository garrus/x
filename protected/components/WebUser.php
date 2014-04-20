<?php
/**
 * Created by JetBrains PhpStorm.
 * User: user
 * Date: 14-1-13
 * Time: 下午11:50
 * To change this template use File | Settings | File Templates.
 */
/**
 * Class WebUser
 *
 * Available state
 * @property string $nick
 */
class WebUser extends CWebUser{

    public function getIsAdmin(){
        return $this->getState('role') == 'admin';
    }

    public function getIsRep(){
        return $this->getState('role') == 'rep';
    }

    public function getIsCustomer(){
        return $this->getState('role') == 'customer';
    }

    public function getReturnUrl($defaultUrl=null){

        if (!$defaultUrl) {
            if (!$this->isGuest) {
                $defaultUrl = $this->getDashboardUrl() ?: null;
            }
        }
        return parent::getReturnUrl($defaultUrl);
    }

    public function getVisitorCity(){

        $cookies = Yii::app()->request->cookies;
        if ($cookies->contains('city')) {
            return $cookies['city'];
        }

        $ip = Yii::app()->request->getUserHostAddress();
        //$ip = '114.98.65.196';
        $ret = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip='. $ip);

        if ($ret) {
            $info = json_decode($ret);
            if ($info->code != 1) {
                $city = $info->data->region. $info->data->city;

                $cookie = new CHttpCookie('city', $city, array('expire' => time() + 86400));
                $cookies->add('city', $cookie);
                return $city;
            }
        }

        return '未知地区';
    }

    public function getDashboardUrl(){
        if (!$this->isGuest) {
            switch ($this->getstate('role')) {
                case 'rep':
                    return array('rep/index');
                case 'admin':
                    return array('xa/index');
                default:
                    break;
            }
        }
        return '';
    }

}