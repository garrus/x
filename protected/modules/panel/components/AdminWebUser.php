<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yaowenh
 * Date: 14-1-27
 * Time: 下午8:15
 * To change this template use File | Settings | File Templates.
 */

class AdminWebUser extends CWebUser{

    public $authFilePath;

    /**
     * @return string
     */
    public function getStateKeyPrefix(){
        return md5('9g207tq28grpiasbdf9y79P(Gjk23gp19urvqgbd;khSDfsfSDFsERRTRGex');
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function doAdminLogin($username, $password){

        $ui = $this->createIdentity($username, $password);
        if ($ui->authenticate()) {
            $this->login($ui);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $username
     * @param $password
     * @return AdminUserIdentity
     * @throws CException
     */
    public function createIdentity($username, $password){

        if ($this->authFilePath && file_exists($this->authFilePath)) {
            $credentials = array();
            foreach (new SplFileObject($this->authFilePath, 'r') as $line) {
                $tokens = explode('=', trim($line), 2);
                if (count($tokens) == 2) {
                    $credentials[trim($tokens[0])] = trim($tokens[1]);
                }
            }

            $ui = new AdminUserIdentity($username, $password);
            $ui->credentials = $credentials;
            return $ui;
        } else {
            throw new CException('Unable to locate auth file.');
        }
    }
}


class AdminUserIdentity extends CUserIdentity{

    public $credentials=array();

    public function authenticate(){

        if (isset($this->credentials[$this->username])) {
            if ($this->credentials[$this->username] == $this->password) {
                return true;
            }
        }
        return false;
    }
}