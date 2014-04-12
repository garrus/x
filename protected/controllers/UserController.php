<?php

class UserController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('deny',  // deny all guest user
				'users'=>array('?'),
			),
		);
	}

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     */
    public function actionModifyProfile()
    {
        $model = User::model()->findByPk(Yii::app()->user->id);
        if (!$model) {
            Yii::app()->user->logout();
            $this->redirect(array('site/login'));
        }

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model, 'user-form');

        if(isset($_POST['User']))
        {
            $model->attributes=$_POST['User'];
            if ($model->save()) {
                $success = true;
            }
        }

        $this->render('modify_profile',array(
            'model'=>$model,
            'success' => !empty($success)
        ));
    }


}
