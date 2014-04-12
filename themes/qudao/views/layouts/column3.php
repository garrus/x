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
        'title' => '在线客服',
    ));
    $this->widget('application.widgets.ContactUs.ContactUsWidget');
    $this->endWidget();

    $this->beginWidget('zii.widgets.CPortlet', array(
        'title' => '产品列表',
    ));
    $this->widget('application.widgets.ProdList.ProdListWidget');
    $this->endWidget();
    ?>
</div>

<div class="span-16" style="margin-top: 10px;">

    <?php if (!empty($this->breadcrumbs)) {
        $this->widget('zii.widgets.CBreadcrumbs', array(
			'links' => $this->breadcrumbs,
		));
    }?>

    <?php echo $content;?>
</div>

<div class="span-3">
    <?php echo 'aha';?>
</div>
<?php $this->endContent();