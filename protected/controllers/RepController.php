<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-3-23
 * Time: 下午6:50
 */

class RepController extends Controller{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/rep';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
        );
    }

    public function accessRules(){
        return array(
            array('allow',
                'expression' => 'Yii::app()->user->isRep',
            ),
            array('deny')
        );
    }

    public function actionIndex(){
        $this->render('index');
    }

    public function actionMyCustomers(){

        /** @var User $user */
        $user = User::model()->isCustomerOf(Yii::app()->user->id);
        $dataProvider = new CActiveDataProvider($user, array(
            'sort' => array(
                'attributes' => array('first_name', 'last_name', 'display_name', 'create_time'),
                'defaultOrder' => array('create_time' => false),
            )
        ));

        $this->render('my_customers', array(
            'dataProvider' => $dataProvider,
        ));
    }

} 