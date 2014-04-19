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

    <div class="navbar navbar-fixed-top">

        <div class="navbar-inner">
            <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <!-- <a class="brand" href="#"><?php echo Yii::t('admin', 'Admin Dashboard');?></a> -->
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->

            <div class="container">
                <div class="nav-collapse collapse">
                    <?php $this->widget('bootstrap.widgets.TbMenu', array(
                        'items' => array(
                            array('label' => Yii::t('admin', 'Home'), 'url' => array('xa/index')),
                            array('label' => Yii::t('admin', 'Production'), 'url' => array('xa/prodIndex'), 'active' => strpos($this->action->id, 'prod') === 0),
                            array('label' => Yii::t('admin', 'Back to Site'), 'url' => array('site/index')),
                            array('label' => Yii::t('admin', 'Logout'), 'url' => array('site/logout')),
                        )
                    ));?>
                </div><!--/.nav-collapse -->
            </div>

        </div>
    </div><!-- /.navbar-inner -->

    <div class="container">
        <div class="content row-fluid">
            <div class="span3">
                <?php
                $this->widget('TbMenu', array(
                    'type' => TbMenu::TYPE_LIST,
                    'items'=>$this->menu,
                    'htmlOptions'=>array('class'=>'operations'),
                ));
                ?>
            </div>

            <div class="span9">
                <?php echo $content; ?>
            </div>

        </div>

        <hr>
        <div class="text-center footer">
            Copyright &copy; <?php echo date('Y'); ?> by My Company.<br/>
            All Rights Reserved.<br/>
            <?php echo Yii::powered(); ?>
        </div><!-- footer -->
    </div>


</body>
</html>
