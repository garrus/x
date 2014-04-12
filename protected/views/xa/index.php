<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-3-29
 * Time: 下午11:57
 */
$this->menu = array(
    array('label' => Yii::t('admin', 'Users'), 'url' => array('xa/usrIndex')),
    array('label' => Yii::t('admin', 'Productions'), 'url' => array('xa/prodIndex')),
    array('label' => Yii::t('admin', 'Back To Site'), 'url' => array('site/index')),
);
?>

<h1><?php echo Yii::t('admin', 'Welcome to Admin Dashboard');?></h1>
<div class="notice-success">
    <?php echo Yii::t('admin', 'Your last login time:');?>
    <?php echo Yii::app()->user->lastLoginTime;?>
</div>