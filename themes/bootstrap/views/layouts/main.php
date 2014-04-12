<?php
/**
 * @var $this Controller
 * @var string $content
 */
$themeBaseUrl = Yii::app()->theme->baseUrl;
?>
<!DOCTYPE html>
<html xml:lang="cn" lang="cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="cn" />
    <link type="text/css" rel="stylesheet" href="<?php echo $themeBaseUrl;?>/css/main.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <?php Yii::app()->bootstrap->register();?>

    <script type="text/javascript" src="<?php echo $themeBaseUrl;?>/js/global.js"></script>
</head>

<body>

    <div class="navbar navbar-fixed-top navbar-inverse">
        <div class="navbar-inner">
            <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- <a class="brand" href="#"><?php echo Yii::t('site', 'Project Name');?></a> -->
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <div class="nav-collapse collapse container">
                <?php $this->widget('bootstrap.widgets.TbMenu', array(
                    'items' => array(
                        array('label' => Yii::t('site', 'Home'), 'url' => array('site/index')),
                        array('label' => Yii::t('site', 'About'), 'url' => array('site/about')),
                        array('label' => Yii::t('site', 'Contact'), 'url' => array('site/contact')),
                    )
                ));?>
            </div><!--/.nav-collapse -->

        </div>
    </div><!-- /.navbar -->


    <div class="container">
	    <?php echo $content; ?>
    </div>
    <hr>
    <div class="container footer">
        Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
        All Rights Reserved.<br/>
        <?php echo Yii::powered(); ?>
    </div><!-- footer -->

</body>
</html>
