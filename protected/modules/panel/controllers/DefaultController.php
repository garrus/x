<?php

class DefaultController extends PanelController{


	public function actionIndex(){

		$this->render('index');

	}

	public function actionEmailGw() {
		$this->render('emailgw');
	}

    public function actionLogin(){

        $request = Yii::app()->request;
        $username = $request->getPost('username');
        $password = $request->getPost('password');
        $error = '';

        if ($username && $password) {
            if (Yii::app()->user->doAdminLogin($username, $password)) {
                $this->redirect(Yii::app()->user->returnUrl);
            } else {
                sleep(1);
                $error = 'Invalid credential.';
            }
        }

        ob_start();

        echo '<h2>Admin Login</h2><hr>';
        echo CHtml::beginForm();
        echo '<p style="color: red;">'. $error. '</p>';
        echo CHtml::textField('username', $username, array('placeholder' => 'username'));
        echo CHtml::passwordField('password', $password, array('placeholder' => 'password'));
        echo CHtml::submitButton('Login');
        echo CHtml::endForm();

        $this->renderText(ob_get_clean());
    }

    public function actionLogout(){

        Yii::app()->user->logout();
        $this->redirect('login');
    }

	public function actionDealCreate(){
		$allRecord = PasswordReset::model()->findAll();
		$result = array();
		foreach ($allRecord as $record) {
			$domain = CoreLib::getEmailDomain($record->email);
			try {
				$org = ZOrg::model()->findByDomain($domain);
			} catch ( Exception $e ) {
				continue;
			}
			$user = ZUser::model()->findByEmail($record->email);
			if ( $user == null ) {
				$result[] = $record->email;
			} else {
				if (!$org->hasMember( $user->id )) {
					$result[] = $record->email;
				}
			}
		}

		$this->render('createAccount', array('emailData'=>$result));

	}

}
