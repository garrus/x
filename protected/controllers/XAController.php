<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-3-23
 * Time: 下午6:52
 */

/**
 * Class XAController
 *
 * The admin controller
 * User XA to avoid admin-scan
 */
class XAController extends Controller{

    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout='//layouts/admin';

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
                'actions' => array('login'),
                'users' => array('?')
            ),
            array('allow',
                'expression' => 'Yii::app()->user->isAdmin',
                'actions' => array()
            ),

            array('deny')
        );
    }

    public function actions(){
        return array(
            'ueditor.' => array(
                'class' => 'ext.wdueditor.WDueditor',
            )
        );
    }

    public function init(){
        Yii::app()->theme = 'bootstrap';
        Yii::app()->user->loginUrl = array('xa/login');
        parent::init();
    }


    /**
     * Displays the login page
     */
    public function actionLogin()
    {
        $this->layout = '//layouts/login';

        $model=new LoginForm;

        // if it is ajax validation request
        if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        // collect user input data
        if(isset($_POST['LoginForm']))
        {
            $model->attributes=$_POST['LoginForm'];
            // validate user input and redirect to the previous page if valid
            if ($model->validate() && $model->login()) {
                $this->redirect(array('xa/index'));
            }

        }
        // display the login form
        $this->render('login',array('model'=>$model));
    }


    public function actionIndex(){

        $this->render('index');
    }

    public function actionProdIndex(){

        $dataProvider=new CActiveDataProvider('Product');
        $this->render('prod/index',array(
            'dataProvider'=>$dataProvider,
        ));
    }


    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionProdView($id)
    {
        $this->render('prod/view',array(
            'model'=>$this->loadProd($id),
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionProdCreate()
    {
        $model=new Product;

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model, 'user-form');

        if(isset($_POST['Product']))
        {
            $model->attributes=$_POST['Product'];
            if($model->save())
                $this->redirect(array('prodView','id'=>$model->id));
        }

        $this->render('prod/create',array(
            'model'=>$model,
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionProdUpdate($id)
    {
        $model=$this->loadProd($id);

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model, 'user-form');

        if(isset($_POST['Product']))
        {
            $model->attributes=$_POST['Product'];
            if($model->save())
                $this->redirect(array('prodView','id'=>$model->id));
        }

        $this->render('prod/update',array(
            'model'=>$model,
        ));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     * @throws CHttpException
     */
    public function actionProdDelete($id)
    {
        if(Yii::app()->request->isPostRequest)
        {
            // we only allow deletion via POST request
            $this->loadProd($id)->setIsDeleted(true);

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!isset($_GET['ajax']))
                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('usrDelete'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }


    /**
     * @param $id
     * @return Product
     * @throws CHttpException
     */
    public function loadProd($id){
        $model = Product::model()->findByPk($id);
        if ($model===null)
            throw new CHttpException(404,'您所请求的页面不存在.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param CModel $model the model to be validated
     * @param $id
     */
    protected function performAjaxValidation($model, $id)
    {
        if(isset($_POST['ajax']) && $_POST['ajax']===$id)
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
} 