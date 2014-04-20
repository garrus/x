<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-4-20
 * Time: 下午1:38
 * @var Product $data
 * @var integer $index
 */
?>
<li class="clearfix">
    <h4 class="title"><?php echo CHtml::link($data->name, array('prod/view', 'id' => $data->id));?></h4>
    <p>
        <span class="info"><?php echo $data->getDescriptionInShort();?></span>
        <?php echo CHtml::link('查看详情 >>', array('prod/view', 'id' => $data->id), array('class' => 'view-detail'));?>
    </p>
</li>
