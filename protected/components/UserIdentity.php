<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    /**
     * @return string
     */
    public function getId(){
        return $this->username;
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->username;
    }

    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        /** @var ConfigManager $config */
        $config = Yii::app()->config;
        if ($this->username == $config->adminId) {
            $isAdmin = $config->adminPassword === self::encryptPassword($this->password, $config->adminSalt);
            if ($isAdmin) {
                $this->setState('role', 'admin');
                $this->errorCode = self::ERROR_NONE;
                return true;
            }
        }

        $this->errorCode = self::ERROR_PASSWORD_INVALID;
        $this->errorMessage = Yii::t('user', 'Login name and password don\'t match.');
        return false;
    }

    /**
     * @param $password
     * @param $salt
     * @return string
     */
    public static function encryptPassword($password, $salt) {
        return md5($salt. md5($password));
    }

}