<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-12
 * Time: 下午9:58
 * @var string $content
 * @var Controller $this
 */
$this->beginContent('//layouts/main');
?>

    <div class="span-4 clearfix">

        <?php $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => '欢迎来访',
        ));
        echo '<p>欢迎来自 '. Yii::app()->user->getVisitorCity(). ' 的访客。</p>';
        $this->widget('application.widgets.ContactUs.ContactUsWidget');
        $this->endWidget();

        $this->beginWidget('zii.widgets.CPortlet', array(
            'title' => '产品列表',
        ));
        $this->widget('application.widgets.ProdList.ProdListWidget');
        $this->endWidget();
        ?>
    </div>

    <div class="span-19" style="margin-right: 0;">

        <?php if (!empty($this->breadcrumbs)) {
            $this->widget('zii.widgets.CBreadcrumbs', array(
                'homeLink' => CHtml::link('网站首页', array('site/index')),
                'links' => $this->breadcrumbs,
            ));
        }?>

        <?php echo $content;?>
    </div>


<?php $this->endContent();