<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-20
 * Time: 下午1:35
 * @var ProdController $this
 * @var CActiveDataProvider $dataProvider
 */
$this->breadcrumbs = array(
    '产品列表',
);
?>
<div style="margin: 20px;">

<?php
$this->widget('zii.widgets.CListView', array(
    'id' => 'prod-list',
    'dataProvider' => $dataProvider,
    'itemView' => '_view',
    'summaryText' => '当前共为您找到 {count} 件产品'
));?>

</div>