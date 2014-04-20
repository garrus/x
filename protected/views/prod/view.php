<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-20
 * Time: 下午12:24
 *
 * @var ProdController $this
 * @var Product $model
 */
$this->breadcrumbs = array(
    '产品列表' => array('prod/index'),
    '产品详情',
);

?>
<h1 class="prod-name"><?php echo $model->name;?></h1>

<p class="prod-desc"><?php echo $model->description;?></p>

<div class="prod-content" id="prod-desc" style="margin-left: 20px;"><?php echo $model->content;?></div>

<?php
$this->widget('ext.wdueditor.WDueditor', array(
    'parse' => true,
    'id' => 'prod-desc',
));