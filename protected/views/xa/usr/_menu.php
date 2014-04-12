<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-3-30
 * Time: 上午1:11
 * @var User $model
 */
$this->menu = array(
    array('label'=>Yii::t('admin', 'All Users'),'url'=>array('xa/usrIndex')),
    array('label'=>Yii::t('admin', 'Create User'),'url'=>array('xa/usrCreate')),
);