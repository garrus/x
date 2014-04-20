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
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->

            <div class="container">
                <div class="nav-collapse collapse">
                    <?php $this->widget('bootstrap.widgets.TbMenu', array(
                        'items' => array(
                            array('label' => '管理面板', 'url' => array('xa/index')),
                            array('label' => '产品管理', 'url' => array('xa/prodIndex'), 'active' => strpos($this->action->id, 'prod') === 0),
                            array('label' => '配置管理', 'url' => array('xa/configIndex'), 'active' => strpos($this->action->id, 'config') === 0),
                            array('label' => '回到前台', 'url' => array('site/index')),
                            array('label' => '安全登出', 'url' => array('site/logout')),
                        )
                    ));?>
                </div><!--/.nav-collapse -->
            </div>

        </div>
    </div><!-- /.navbar-inner -->

    <div class="container">
        <div class="content row-fluid">
            <div class="span2">
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
            Copyright &copy; <?php echo date('Y'); ?><br/>
            All Rights Reserved.<br/>
            <?php echo Yii::powered(); ?>
        </div><!-- footer -->
    </div>


</body>
</html>
