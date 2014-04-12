<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

    /**
     * @var User
     */
    private $_user=null;

    /**
     * @return string
     */
    public function getId(){
        return $this->_user ? $this->_user->id : '';
    }

    /**
     * @return string
     */
    public function getName(){
        return $this->_user ? $this->_user->getDisplayName() : '';
    }

    /**
     * @return User
     */
    public function getUser(){
        return $this->_user;
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
        $user = null;
        if ($this->username) {
            /** @var User $user */
            $user = User::model()->findByAttributes(array('login_name' => $this->username));
        }
        if (!$user) {
            $this->errorCode = self::ERROR_USERNAME_INVALID;
            $this->errorMessage = Yii::t('user', 'Login name is invalid or does not exist.');
            return false;
        }
        if (!$user->validatePassword($this->password)) {
            $this->errorCode = self::ERROR_PASSWORD_INVALID;
            $this->errorMessage = Yii::t('user', 'Login name and password don\'t match.');
            return false;
        }

        $this->errorCode = self::ERROR_NONE;
        $this->_user = $user;
        $this->setState('role', $user->role);
        $this->setState('lastLoginTime', $user->last_login_time);
        return true;
    }
}