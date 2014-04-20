<?php
/**
 * @var Product $model
 */
$this->renderPartial('prod/_menu');?>

<h1><?php echo $model->name; ?></h1>
<hr>



<?php
if ($model->is_deleted) :?>
<div class="alert">
    这个产品被隐藏了。点击下面的“<strong>修改</strong>”按钮来取消隐藏。
</div>
<?php endif;

echo '<p>';
echo CHtml::link('修改', array('xa/prodUpdate', 'id' => $model->id), array('class' => 'btn btn-primary btn-small'));
echo '</p>';
$this->widget('bootstrap.widgets.TbDetailView',array(
    'data'=>$model,
    'attributes'=>array(
        'name',
        'cate',
        'create_time',
        'update_time',

        array(
            'name' => 'is_deleted',
            'value' => $model->is_deleted ? '是' : '否',
        ),
        'description',
        array(
            'cssClass' => 'prod-content',
            'name' => 'content',
            'value' => '<div id="prod-content">'. $model->content. '</div>',
            'type' => 'raw',
        )
    ),
));

echo CHtml::link('删除产品', array('xa/prodDelete', 'id' => $model->id), array('onclick' => 'return confirm("你确定要删除这个产品吗？（删除后不可恢复！）");', 'class' => 'btn btn-danger btn-small'));

$this->widget('ext.wdueditor.WDueditor', array(
    'parse' => true,
    'id' => 'prod-content',
));
