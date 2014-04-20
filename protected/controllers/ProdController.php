<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-19
 * Time: 下午3:29
 */

class ProdController extends Controller{

    /**
     * Declares class-based actions.
     */
    public function actions()
    {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha'=>array(
                'class'=>'CCaptchaAction',
                'backColor'=>0xFFFFFF,
            ),
            // page action renders "static" pages stored under 'protected/views/site/pages'
            // They can be accessed via: index.php?r=site/page&view=FileName
            'page'=>array(
                'class'=>'CViewAction',
            ),
            'ueditor.' => array(
                'class' => 'ext.wdueditor.WDueditor',
            )
        );
    }

    public function actionIndex(){

        $model = new Product('search');
        $this->render('index', array(
            'dataProvider' => $model->search(),
        ));

    }


    public function actionView($id){
        $model = $this->loadModel($id);
        $this->render('view', array(
            'model' => $model
        ));
    }

    /**
     * @param $id
     * @return Product
     * @throws CHttpException
     */
    private function loadModel($id){

        /** @var Product $model */
        $model = Product::model()->findByPk($id);
        if (!$model) {
            throw new CHttpException(404, Yii::t('site', '您所请求的页面不存在。'));
        }

        if ($model->is_deleted) {
            throw new CHttpException(404, Yii::t('site', '您所请求的页面已经被删除了。'));
        }

        return $model;
    }

} 