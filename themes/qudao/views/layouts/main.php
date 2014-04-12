<?php
/**
 * @var string $content
 * @var Controller $this
 */
$baseUrl = Yii::app()->request->baseUrl;
$themeBaseUrl = Yii::app()->theme->baseUrl;
$assetsUrl = Yii::app()->assetManager->publish(Yii::app()->basePath.'/modules/panel/css', false, -1, true);

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <!-- blueprint CSS framework -->
    <link rel="stylesheet" type="text/css" href="<?php echo $themeBaseUrl; ?>/css/screen.css" media="screen, projection" />
    <link rel="stylesheet" type="text/css" href="<?php echo $themeBaseUrl; ?>/css/print.css" media="print" />
    <!--[if lt IE 8]>
    <link rel="stylesheet" type="text/css" href="<?php echo $themeBaseUrl; ?>/css/ie.css" media="screen, projection" />
    <![endif]-->

    <link rel="stylesheet" type="text/css" href="<?php echo $themeBaseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo $themeBaseUrl; ?>/css/form.css" />

    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body style="background: white;">

<div>

    <div class="container">
        <div id="logo"><?php echo CHtml::encode(Yii::app()->name); ?></div>
    </div><!-- header -->

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
            'items' => array(
                array('label' => '网站首页', 'url' => array('site/index')),
                array('label' => '所有产品', 'url' => array('prod/index')),
                array('label' => '联系我们', 'url' => array('site/contact')),
            ),
        )); ?>
    </div><!-- mainmenu -->

    <div class="container" style="margin-bottom: 10px;">

        <?php echo $content; ?>
    </div>
    <div id="footer">
    </div><!-- footer -->

</div><!-- page -->

</body>
</html>
